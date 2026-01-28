<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * State belongs to a Country
     * Example: India → Himachal Pradesh, Goa
     *          UAE → Dubai
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * State has many Destinations
     * Example: Himachal → Shimla, Manali
     */
    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }

    /**
     * Scope: only active states
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
