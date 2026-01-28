<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Theme;
use App\Models\Destination;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with(['theme.destination'])->latest()->get();
        return view('packages.index', compact('packages'));
    }

    public function create()
    {
        $destinations = Destination::active()->with('themes')->get();
        $themes = Theme::active()->get();

        return view('packages.form', compact('destinations', 'themes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'theme_id'   => 'required|exists:themes,id',
            'name'       => 'required|string|max:255',
            'nights'     => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',       
            'status'     => 'required|boolean',
            'discount'    => 'nullable|numeric|min:0',  
            'description' => 'required|string',  
        ]);

        Package::create($request->all());

        return redirect()->route('packages.index')
            ->with('success', 'Package added successfully');
    }

    public function edit(Package $package)
    {
        $destinations = Destination::active()->with('themes')->get();
        $themes = Theme::active()->get();

        return view('packages.form', compact('package', 'destinations', 'themes'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'theme_id'   => 'required|exists:themes,id',
            'name'       => 'required|string|max:255',
            'nights'     => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',          
            'status'     => 'required|boolean',
            'discount'    => 'nullable|numeric|min:0',  
            'description' => 'required|string',  
        ]);

        $package->update($request->all());

        return redirect()->route('packages.index')
            ->with('success', 'Package updated successfully');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully');
    }
}