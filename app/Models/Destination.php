<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'name',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Destination belongs to a State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Destination has many Themes
     */
    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    /**
     * Scope for active destinations
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}