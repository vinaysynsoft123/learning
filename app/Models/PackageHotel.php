<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageHotel extends Model
{
    protected $fillable = [
        'package_id',
        'destination_id',
        'hotel_category_id',
        'hotel_id'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function hotelCategory()
    {
        return $this->belongsTo(HotelCategory::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
