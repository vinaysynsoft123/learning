<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelRoomType;
use Illuminate\Http\Request;

class HotelRoomTypeController extends Controller
{
    public function index($hotelId)
    {
       
        $hotel = Hotel::findOrFail($hotelId);
        $roomTypes = HotelRoomType::where('hotel_id', $hotelId)->get();

        return view('hotel_rooms.index', compact('hotel', 'roomTypes'));
    }

     public function create($hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        $roomType = new HotelRoomType(); 

        return view('hotel_rooms.manage', compact('hotel', 'roomType'));
    }


       public function store(Request $request, $hotelId)
    {
        $data = $request->validate([
            'name' => 'required',
            'base_pax' => 'required|integer',
            'max_pax' => 'required|integer',
            'base_price' => 'required|numeric',
            'extra_adult_price' => 'nullable|numeric',
            'child_with_bed_price' => 'nullable|numeric',
            'child_no_bed_price' => 'nullable|numeric',
            'infant_price' => 'nullable|numeric',
            'season_start' => 'nullable|date',
            'season_end' => 'nullable|date',
            'season_base_price' => 'nullable|numeric',
            'season_extra_adult_price' => 'nullable|numeric',
            'season_child_with_bed_price' => 'nullable|numeric',
            'season_child_no_bed_price' => 'nullable|numeric',
            'status' => 'required'
        ]);

        $data['hotel_id'] = $hotelId;

        HotelRoomType::create($data);

        return redirect()->route('rooms.index', $hotelId)
            ->with('success', 'Room type added');
    }

     public function edit($hotelId, $roomId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        $roomType = HotelRoomType::findOrFail($roomId);

        return view('hotel_rooms.manage', compact('hotel', 'roomType'));
    }

    public function update(Request $request, $hotelId, $roomId)
    {
        $roomType = HotelRoomType::findOrFail($roomId);

        $data = $request->validate([
            'name' => 'required',
            'base_pax' => 'required|integer',
            'max_pax' => 'required|integer',
            'base_price' => 'required|numeric',
            'extra_adult_price' => 'nullable|numeric',
            'child_with_bed_price' => 'nullable|numeric',
            'child_no_bed_price' => 'nullable|numeric',
            'infant_price' => 'nullable|numeric',
            'season_start' => 'nullable|date',
            'season_end' => 'nullable|date',
            'season_base_price' => 'nullable|numeric',
            'season_extra_adult_price' => 'nullable|numeric',
            'season_child_with_bed_price' => 'nullable|numeric',
            'season_child_no_bed_price' => 'nullable|numeric',
            'status' => 'required'
        ]);

        $roomType->update($data);

        return redirect()->route('rooms.index', $hotelId)
            ->with('success', 'Room type updated');
    }
}