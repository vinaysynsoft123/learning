<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Theme;
use App\Models\Destination;
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
        $themes = Theme::active()->get();
        $destinations = Destination::active()->get();
        return view('hotels.manage', compact('categories', 'themes', 'destinations'));
    }

 public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|max:255',
            'hotel_category_id' => 'required|exists:hotel_categories,id',
            'status' => 'required|in:0,1',
            'theme_ids' => 'required|array',
            'theme_ids.*' => 'exists:themes,id',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        // Create hotel once
        $hotel = Hotel::create($request->except('theme_ids'));

        // Attach multiple themes
        $hotel->themes()->sync($request->theme_ids);

        return redirect()
            ->route('hotels.index')
            ->with('success', 'Hotel created successfully');
    }

    public function show(Hotel $hotel)
    {
        $hotel->load('category','roomTypes');
        return view('hotels.show', compact('hotel'));
    }

  public function edit(Hotel $hotel)
    {
        $hotel->load('themes'); 

        $categories = HotelCategory::all();
        $themes = Theme::active()->get();
        $destinations = Destination::active()->get();

        return view('hotels.manage', compact(
            'hotel','categories','themes','destinations'
        ));
    }


   public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|max:255',
            'hotel_category_id' => 'required|exists:hotel_categories,id',
            'status' => 'required|in:0,1',
            'theme_ids' => 'required|array',
            'theme_ids.*' => 'exists:themes,id',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        // Update hotel fields
        $hotel->update($request->except('theme_ids'));

        // Sync multiple themes
        $hotel->themes()->sync($request->theme_ids);

        return redirect()
            ->route('hotels.index')
            ->with('success', 'Hotel updated successfully');
    }


    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted');
    }
}