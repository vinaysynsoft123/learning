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
        return view('vehicles.manage', [
            'vehicle' => null,
            'destinations' => $destinations
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'capacity'       => 'required|integer|min:1',
            'type'           => 'required|in:per_day,per_km,tour_basis',
            'price_per_day'  => 'required_unless:type,tour_basis|nullable|numeric|min:0',
            'tour_rates'     => 'required_if:type,tour_basis|nullable|string',
            'status'         => 'required|boolean',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle added successfully');
    }

    public function edit(Vehicle $vehicle)
    {
        $destinations = Destination::active()->get();
        return view('vehicles.manage', compact('vehicle', 'destinations'));
    }


    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'capacity'       => 'required|integer|min:1',
            'type'           => 'required|in:per_day,per_km,tour_basis',
            'price_per_day'  => 'required_unless:type,tour_basis|nullable|numeric|min:0',
            'tour_rates'     => 'required_if:type,tour_basis|nullable|string',
            'status'         => 'required|boolean',
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
