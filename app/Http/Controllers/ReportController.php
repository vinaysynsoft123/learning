<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HotelCategory;
use App\Models\Vehicle;
use App\Models\Theme;
use App\Models\Package;
use App\Models\Destination;
use App\Models\TourCalculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId      = $request->user_id;
        $startDate   = $request->start_date;
        $endDate     = $request->end_date;
        $quickFilter = $request->quick_filter;

        // Apply quick filters if selected
        if ($quickFilter) {
            $endDate = now()->toDateString();
            if ($quickFilter == '3m') {
                $startDate = now()->subMonths(3)->toDateString();
            } elseif ($quickFilter == '6m') {
                $startDate = now()->subMonths(6)->toDateString();
            } elseif ($quickFilter == 'last_year') {
                $startDate = now()->subYear()->startOfYear()->toDateString();
                $endDate = now()->subYear()->endOfYear()->toDateString();
            } elseif ($quickFilter == 'this_year') {
                $startDate = now()->startOfYear()->toDateString();
                $endDate = now()->toDateString();
            }
        }

        // Query Tour Calculations for revenue and package counts
        $query = TourCalculation::query();

        if ($userId) {
            $query->where('agent_id', $userId);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $calculations = $query->get();

        $totalEarnings = $calculations->sum('total_price');
        $packageCount  = $calculations->count();
        // Since there's no payment status, we'll assume "pending" logic is TBD or use a placeholder
        $pendingAmount = 0; 

        // Master counts (optional: keep or remove depending on view needs)
        $totalUsers          = User::count();
        $totalPackages       = Package::count();
        $totalDestinations   = Destination::count();

        // Monthly revenue for chart (based on filters)
        $monthlyRevenue = TourCalculation::select(
                DB::raw('MONTH(created_at) as month'), 
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_price) as total')
            )
            ->when($userId, fn($q) => $q->where('agent_id', $userId))
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $users = User::whereIn('role', ['Staff', 'Agent', 'Freelancer'])->get();

        return view('reports.index', compact(
            'totalUsers',
            'totalPackages',
            'totalDestinations',
            'totalEarnings',
            'packageCount',
            'pendingAmount',
            'users',
            'userId',
            'startDate',
            'endDate',
            'quickFilter',
            'monthlyRevenue'
        ));
    }
}
