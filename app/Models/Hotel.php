<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'city',
        'state',
        'hotel_category_id',
        'destination_id',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(HotelCategory::class, 'hotel_category_id');
    }

    public function roomTypes()
    {
        return $this->hasMany(HotelRoomType::class);
    }

    public function themes()
    {
        return $this->belongsToMany(Theme::class);
    }
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}

