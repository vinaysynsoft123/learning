<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HotelCategory;
use App\Models\Vehicle;
use App\Models\Theme;
use App\Models\Package;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year  = $request->year ?? now()->year;

        // ================= MASTER COUNTS =================
        $totalUsers          = User::whereYear('created_at', $year)->count();
        $totalHotelCategories= HotelCategory::whereYear('created_at', $year)->count();
        $totalVehicles       = Vehicle::whereYear('created_at', $year)->count();
        $totalThemes         = Theme::whereYear('created_at', $year)->count();
        $totalPackages       = Package::whereYear('created_at', $year)->count();
        $totalDestinations   = Destination::whereYear('created_at', $year)->count();

        // ================= MONTHLY DATA =================
        $monthlyUsers = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyHotelCategories = HotelCategory::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyVehicles = Vehicle::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('reports.index', compact(
            'year',
            'totalUsers',
            'totalHotelCategories',
            'totalVehicles',
            'totalThemes',
            'totalPackages',
            'totalDestinations',
            'monthlyUsers',
            'monthlyHotelCategories',
            'monthlyVehicles'
        ));
    }
}
