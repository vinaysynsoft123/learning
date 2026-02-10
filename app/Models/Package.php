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

    ];

    protected $casts = [
        'status' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    // Access theme → destination directly
    public function destination()
    {
        return $this->hasOneThrough(
            Destination::class,
            Theme::class,
            'id',              // Foreign key on themes
            'id',              // Foreign key on destinations
            'theme_id',        // Local key on packages
            'destination_id'   // Local key on themes
        );
    }

    // Scope: Active packages
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

        public function hotelCategory()
    {
        return $this->hasMany(HotelCategory::class);
    }

}