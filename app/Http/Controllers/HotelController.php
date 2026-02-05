<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelCategory;
use Illuminate\Http\Request;

class HotelController extends Controller
{
   public function index(Request $request)
{
    $query = Hotel::with('category');

    // 🔍 Filter: City
    if ($request->filled('city')) {
        $query->where('city', 'like', '%' . $request->city . '%');
    }

    // 🔍 Filter: Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 🔍 Filter: Category
    if ($request->filled('category')) {
        $query->where('hotel_category_id', $request->category);
    }

    // 🔃 Sorting
    $sortBy  = $request->get('sort_by', 'created_at');
    $sortDir = $request->get('sort_dir', 'desc');

    $hotels = $query
        ->orderBy($sortBy, $sortDir)
        ->paginate(20)
        ->withQueryString();

    $categories = HotelCategory::all();

    return view('hotels.index', compact('hotels', 'categories'));
}


    public function create()
    {
        $categories = HotelCategory::all();
        return view('hotels.manage', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|max:255',
            'hotel_category_id' => 'required|exists:hotel_categories,id',
            'status' => 'required|in:0,1',
        ]);

        Hotel::create($request->only(['name','city','state','hotel_category_id','status']));

        return redirect()->route('hotels.index')->with('success', 'Hotel created Successfully');
    }

    public function show(Hotel $hotel)
    {
        $hotel->load('category','roomTypes');
        return view('hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        $categories = HotelCategory::all();
        return view('hotels.manage', compact('hotel','categories'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|max:255',
            'hotel_category_id' => 'required|exists:hotel_categories,id',
            'status' => 'required|in:0,1',
        ]);

        $hotel->update($request->only(['name','city','state','hotel_category_id','status']));

        return redirect()->route('hotels.index')->with('success', 'Hotel updated');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted');
    }
}