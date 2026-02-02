<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\Package;
use App\Models\HotelCategory;

class CalculatorAjaxController extends Controller
{
    public function themes($destinationId)
    {
        return Theme::where('destination_id', $destinationId)
            ->where('status', 1)
            ->get();
    }

    public function packages($themeId)
    {
        return Package::where('theme_id', $themeId)
            ->where('status', 1)
            ->get();
    }

   
}