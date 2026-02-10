<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Destination;
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
        $destinations = Destination::where('status', 1)->get();
        return view('vehicles.manage', compact('destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'capacity'      => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'status'        => 'required|boolean',
            'other'        => 'required',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle added successfully');
    }

  public function edit(Vehicle $vehicle)
{
    $destinations = Destination::where('status', 1)->get();

    return view('vehicles.manage', compact('vehicle', 'destinations'));
}


    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'capacity'      => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'status'        => 'required|boolean',
            'other'        => 'required',
            'destination_id' => 'required|exists:destinations,id',
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
