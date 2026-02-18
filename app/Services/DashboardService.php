<?php

namespace App\Services;
use App\Models\Theme;
use App\Models\Destination;
use App\Models\User;
use App\Models\HotelCategory;
use App\Models\Vehicle;
use App\Models\Package;

class DashboardService
{
    public function getDashboardData(): array
    {
        return [
            'counts' => [
                'themes'          => \App\Models\Theme::count(),
                'destinations'    => \App\Models\Destination::count(),
                'users'           => \App\Models\User::count(),
                'hotelCategories' => \App\Models\HotelCategory::count(),
                'vehicles'        => \App\Models\Vehicle::count(),
                'packages'        => \App\Models\Package::count(),
                'calculations'    => \App\Models\TourCalculation::count(),
            ],
            'totalRevenue' => \App\Models\TourCalculation::sum('total_price'),
            'recentUsers' => \App\Models\User::latest()->take(5)->get(),
            'recentCalculations' => \App\Models\TourCalculation::with(['agent', 'package', 'destination'])->latest()->take(5)->get(),
            'userBreakdown' => \App\Models\User::select('role', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('role')
                ->pluck('count', 'role'),
            'revenueMonthly' => \App\Models\TourCalculation::select(
                \Illuminate\Support\Facades\DB::raw('MONTH(created_at) as month'),
                \Illuminate\Support\Facades\DB::raw('SUM(total_price) as total')
            )
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->get()
        ];
    }
}
