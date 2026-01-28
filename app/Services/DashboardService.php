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
    public function masterCounts(): array
    {
        return [
            'themes'          => Theme::count(),
            'destinations'    => Destination::count(),
            'users'           => User::count(),
            'hotelCategories' => HotelCategory::count(),
            'vehicles'        => Vehicle::count(),
            'packages'        => Package::count(),
        ];
    }
}
