<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourCalculation extends Model
{
    protected $fillable = [
        'unique_no',
        'agent_id',
        'destination_id',
        'theme_id',
        'package_id',
        'hotel_category_id',
        'travel_date',
        'rooms',
        'total_pax',
        'vehicle_id',
        'markup',
        'gst_applied',
        'total_price',
    ];

    protected $casts = [
        'rooms' => 'array',
        'gst_applied' => 'boolean',
    ];

    public function agent()
{
    return $this->belongsTo(\App\Models\User::class, 'agent_id');
}

public function destination()
{
    return $this->belongsTo(\App\Models\Destination::class);
}

public function package()
{
    return $this->belongsTo(\App\Models\Package::class);
}

public function hotelCategory()
{
    return $this->belongsTo(\App\Models\HotelCategory::class);
}

public function vehicle()
{
    return $this->belongsTo(\App\Models\Vehicle::class);
}

}

