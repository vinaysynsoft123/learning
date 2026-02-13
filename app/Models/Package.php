<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'theme_id',
        'name',
        'nights',
        'base_price',
        'currency',
        'status',
        'description',
        'discount',
        'inclusions',
        'exclusions',
        'destination_id',
    ];

    protected $casts = [
        'status' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    public function theme()
{
    return $this->belongsTo(Theme::class);
}

public function destination()
{
    return $this->belongsTo(Destination::class);
}


    // Scope: Active packages
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function itineraries()
    {
        return $this->hasMany(PackageItinerary::class)->orderBy('sort_order', 'asc');
    }

    public function mappedHotels()
    {
        return $this->hasMany(PackageHotel::class);
    }
}