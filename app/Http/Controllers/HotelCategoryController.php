<?php

namespace App\Http\Controllers;

use App\Models\HotelCategory;
use Illuminate\Http\Request;

class HotelCategoryController extends Controller
{
    public function index()
    {
        $categories = HotelCategory::latest()->get();
        return view('hotel_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('hotel_categories.manage', [
            'category' => null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        HotelCategory::create($request->all());

        return redirect()->route('hotel-categories.index')
            ->with('success', 'Hotel category added successfully');
    }

    public function edit(HotelCategory $hotel_category)
    {
        return view('hotel_categories.manage', [
            'category' => $hotel_category
        ]);
    }

    public function update(Request $request, HotelCategory $hotel_category)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $hotel_category->update($request->all());

        return redirect()->route('hotel-categories.index')
            ->with('success', 'Hotel category updated successfully');
    }

    public function destroy(HotelCategory $hotel_category)
    {
        $hotel_category->delete();

        return redirect()->route('hotel-categories.index')
            ->with('success', 'Hotel category deleted successfully');
    }
}
