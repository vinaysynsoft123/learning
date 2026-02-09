<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'destination_id',
        'name',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relationship: Theme belongs to destination
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // Relationship: Theme has many packages
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    // Scope: Active themes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class);
    }
}