<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\State;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::with('state')->latest()->get();
        return view('destinations.index', compact('destinations'));
    }

    public function create()
    {
        $states = State::active()->get();
        return view('destinations.form', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name'     => 'required|string|max:255',
            'status'   => 'required|boolean',
        ]);

        Destination::create($request->all());

        return redirect()->route('destinations.index')
            ->with('success', 'Destination added successfully');
    }

    public function edit(Destination $destination)
    {
        $states = State::active()->get();
        return view('destinations.form', compact('destination', 'states'));
    }

    public function update(Request $request, Destination $destination)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name'     => 'required|string|max:255',
            'status'   => 'required|boolean',
        ]);

        $destination->update($request->all());

        return redirect()->route('destinations.index')
            ->with('success', 'Destination updated successfully');
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();

        return redirect()->route('destinations.index')
            ->with('success', 'Destination deleted successfully');
    }
}