<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\State;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
  public function index()
{
    $destinations = Destination::with('state')->latest()->paginate(20);
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
        'name' => 'required|string|max:255',
        'type' => 'required|in:domestic,international',
        'status' => 'required|boolean',
        'state_id' => 'nullable|required_if:type,domestic',
    ]);

    $data = $request->all();

    if ($request->type === 'international') {
        $data['state_id'] = null;
    }

    Destination::create($data);

    return redirect()->route('destinations.index')
        ->with('success', 'Destination created successfully.');
}


    public function edit(Destination $destination)
    {
        $states = State::active()->get();
        return view('destinations.form', compact('destination', 'states'));
    }

  public function update(Request $request, Destination $destination)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:domestic,international',
        'status' => 'required|boolean',
        'state_id' => 'nullable|required_if:type,domestic|exists:states,id',
    ]);

    $data = $request->all();

    // International → state NULL
    if ($request->type === 'international') {
        $data['state_id'] = null;
    }

    $destination->update($data);

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