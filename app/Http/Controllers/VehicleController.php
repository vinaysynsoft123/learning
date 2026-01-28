<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->get();
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.manage', [
            'vehicle' => null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'capacity'      => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'status'        => 'required|boolean',
            'other'        => 'required',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle added successfully');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.manage', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'capacity'      => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'status'        => 'required|boolean',
            'other'        => 'required',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully');
    }
}
