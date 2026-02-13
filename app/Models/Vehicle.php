<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'type',
        'price_per_day',
        'tour_rates',
        'status',      
        'destination_id',
    ];

    protected $casts = [
        'status' => 'boolean',
        'price_per_day' => 'decimal:2'
    ];

    // Scope: Active vehicles
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}