<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Destination;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::with('destination')->latest()->get();
        return view('themes.index', compact('themes'));
    }

    public function create()
    {
        $destinations = Destination::active()->get();

        return view('themes.manage', [
            'theme' => null,
            'destinations' => $destinations
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name'           => 'required|string|max:255',
            'status'         => 'required|boolean',
        ]);

        Theme::create($request->all());

        return redirect()->route('themes.index')
            ->with('success', 'Theme added successfully');
    }

    public function edit(Theme $theme)
    {
        $destinations = Destination::active()->get();

        return view('themes.manage', compact('theme', 'destinations'));
    }

    public function update(Request $request, Theme $theme)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name'           => 'required|string|max:255',
            'status'         => 'required|boolean',
        ]);

        $theme->update($request->all());

        return redirect()->route('themes.index')
            ->with('success', 'Theme updated successfully');
    }

    public function destroy(Theme $theme)
    {
        $theme->delete();

        return redirect()->route('themes.index')
            ->with('success', 'Theme deleted successfully');
    }
}
?>