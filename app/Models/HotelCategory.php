<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelCategory extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relationship: Hotel category has many occupancy prices
    public function occupancyPrices()
    {
        return $this->hasMany(HotelOccupancyPrice::class);
    }

    // Scope: Active categories
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
