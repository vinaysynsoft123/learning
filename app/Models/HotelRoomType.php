<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HotelRoomType extends Model
{
    protected $fillable = [
        'hotel_id',
        'name',
        'base_pax',
        'max_pax',
        'base_price',
        'extra_adult_price',
        'child_with_bed_price',
        'child_no_bed_price',
        'infant_price',
        'season_start',
        'season_end',
        'season_base_price',
        'season_extra_adult_price',
        'season_child_with_bed_price',
        'season_child_no_bed_price',
        'status'
    ];

    protected $dates = ['season_start', 'season_end'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * 🔥 Resolve price by date
     */
    public function getPriceByDate($date)
    {
        $date = Carbon::parse($date);

        if ($this->season_start &&
            $date->between($this->season_start, $this->season_end)) {
            return [
                'base_price' => $this->season_base_price,
                'extra_adult_price' => $this->season_extra_adult_price,
                'child_with_bed_price' => $this->season_child_with_bed_price,
                'child_no_bed_price' => $this->season_child_no_bed_price,
            ];
        }

        return [
            'base_price' => $this->base_price,
            'extra_adult_price' => $this->extra_adult_price,
            'child_with_bed_price' => $this->child_with_bed_price,
            'child_no_bed_price' => $this->child_no_bed_price,
        ];
    }
}
