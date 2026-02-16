<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Theme;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\PackageItinerary;
use App\Models\PackageHotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with(['theme.destination'])->latest()->paginate(20); 
        $destinations = Destination::active()->get();
        return view('packages.index', compact('packages','destinations'));
    }


   public function international()
    {
        $packages = Package::with(['theme.destination'])
            ->where('type', 'international')
            ->latest()
            ->paginate(20);

        $destinations = Destination::active()->get();

        return view('packages.index_international', compact('packages', 'destinations'));
    }


    public function domestic()
    {
        $packages = Package::where('type', 'domestic')->get();
        return view('packages.index', compact('packages'));
    }


   public function create()
    {
        $domesticDestinations = Destination::where('type', 'domestic')->active()->get();
        $internationalDestinations = Destination::where('type', 'international')->active()->get();

        $themes = Theme::active()->get();
        $hotels = Hotel::all();
        $categories = HotelCategory::active()->get();

        return view('packages.form', compact(
            'domesticDestinations',
            'internationalDestinations',
            'themes',
            'hotels',
            'categories'
        ));
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
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'type'       => 'required|in:domestic,international',
        ]);

        DB::transaction(function () use ($request) {
            $package = Package::create($request->all());

            // Save night breakdown
            if ($request->has('itineraries')) {
                foreach ($request->itineraries as $index => $item) {
                    $package->itineraries()->create([
                        'destination_id' => $item['destination_id'],
                        'nights'         => $item['nights'],
                        'sort_order'     => $index
                    ]);
                }
            }

            // Save hotel mapping per category
            if ($request->has('mapped_hotels')) {
                foreach ($request->mapped_hotels as $item) {
                    if (!empty($item['hotel_id'])) {
                        $package->mappedHotels()->create([
                            'destination_id'    => $item['destination_id'],
                            'hotel_category_id' => $item['hotel_category_id'],
                            'hotel_id'          => $item['hotel_id'],
                        ]);
                    }
                }
            }
        });

        return redirect()->route('packages.index')
            ->with('success', 'Package added successfully');
    }

   public function edit(Package $package)
{
    $package->load(['itineraries', 'mappedHotels']);

    $domesticDestinations = Destination::where('type', 'domestic')->active()->get();
    $internationalDestinations = Destination::where('type', 'international')->active()->get();

    $themes = Theme::active()->get();
    $hotels = Hotel::all();
    $categories = HotelCategory::active()->get();

    return view('packages.form', compact(
        'package',
        'domesticDestinations',
        'internationalDestinations',
        'themes',
        'hotels',
        'categories'
    ));
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
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'type'       => 'required|in:domestic,international',
        ]);

        DB::transaction(function () use ($request, $package) {
            $package->update($request->all());

            // Sync itineraries
            $package->itineraries()->delete();
            if ($request->has('itineraries')) {
                foreach ($request->itineraries as $index => $item) {
                    $package->itineraries()->create([
                        'destination_id' => $item['destination_id'],
                        'nights'         => $item['nights'],
                        'sort_order'     => $index
                    ]);
                }
            }

            // Sync hotel mappings
            $package->mappedHotels()->delete();
            if ($request->has('mapped_hotels')) {
                foreach ($request->mapped_hotels as $item) {
                    if (!empty($item['hotel_id'])) {
                        $package->mappedHotels()->create([
                            'destination_id'    => $item['destination_id'],
                            'hotel_category_id' => $item['hotel_category_id'],
                            'hotel_id'          => $item['hotel_id'],
                        ]);
                    }
                }
            }
        });

        return redirect()->route('packages.index')
            ->with('success', 'Package updated successfully');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully');
    }

    /**
     * Generate PDF for the package itinerary and pricing
     */
    public function generatePdf(Package $package, Request $request)
    {
        $hotelCategoryId = $request->hotel_category_id;
        
        $package->load(['itineraries.destination', 'mappedHotels' => function($query) use ($hotelCategoryId) {
            $query->where('hotel_category_id', $hotelCategoryId);
        }, 'mappedHotels.hotel']);

        $totalAmount = 0;
        $itineraryData = [];

        foreach ($package->itineraries as $itinerary) {
            $mappedHotel = $package->mappedHotels
                ->where('destination_id', $itinerary->destination_id)
                ->first();

            $hotelName = $mappedHotel ? $mappedHotel->hotel->name : 'To be decided';
            
            // Simplified calculation
            $nightPrice = 2500; 
            $rowTotal = $nightPrice * $itinerary->nights;
            $totalAmount += $rowTotal;

            $itineraryData[] = [
                'destination' => $itinerary->destination->name,
                'nights'      => $itinerary->nights,
                'hotel'       => $hotelName,
                'price'       => $rowTotal
            ];
        }

        $pdf = Pdf::loadView('packages.pdf', [
            'package'       => $package,
            'itineraryData' => $itineraryData,
            'totalAmount'   => $totalAmount
        ]);

        return $pdf->stream($package->name . '-Itinerary.pdf');
    }

    public function show($id)
    {
        $package = Package::findOrFail($id);
        return view('packages.show', compact('package'));
    }

}