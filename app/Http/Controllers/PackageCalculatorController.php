<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Destination;
use App\Models\Theme;
use App\Models\Package;
use App\Models\HotelCategory;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;

class PackageCalculatorController extends Controller
{
    public function index()
    {
        return view('frontend.calculator.index', [
            
            'states'          => State::where('status', 1)->get(),
            'destinations'    => Destination::where('status', 1)->get(),
            'themes'          => Theme::where('status', 1)->get(),
            'packages'        => Package::where('status', 1)->get(),
            'hotelCategories' => HotelCategory::where('status', 1)->get(),
            'vehicles'        => Vehicle::where('status', 1)->get(),
        ]);
    }

 public function calculate(Request $request)
{
    $request->validate([
        'theme_id' => 'required',
        'package_id' => 'required',
        'hotel_category_id' => 'required',
        'vehicle_id' => 'required',
        'rooms' => 'required|array',
    ]);

    $package = Package::findOrFail($request->package_id);
    $hotel   = HotelCategory::findOrFail($request->hotel_category_id);
    $vehicle = Vehicle::findOrFail($request->vehicle_id);

    $perPersonPrice = $package->base_price;
    $hotelPrice     = $hotel->price_multiplier;
    $vehiclePrice   = $vehicle->price_per_day * ($package->nights + 1);

    $adultCount = 0;
    $roomTotal  = 0;

    foreach ($request->rooms as $room) {
        $adults = $room['adults'] ?? 0;
        $childWithBed = $room['child_with_bed'] ?? 0;

        $adultCount += $adults;

        $roomTotal += (($adults + $childWithBed) * $perPersonPrice) + $hotelPrice;
    }

    $subtotal = $roomTotal + $vehiclePrice;

    $markupPercent = $request->markup ?? 0;
    $markupAmount  = ($subtotal * $markupPercent) / 100;

    $gstAmount = $request->has('add_gst')
        ? (($subtotal + $markupAmount) * 0.05)
        : 0;

    $totalPrice = $subtotal + $markupAmount + $gstAmount;

    $token = Str::uuid()->toString();

    // ✅ FIX: IDs stored in session
    session([
        "quotation_$token" => [
            'package_id'        => $package->id,
            'hotel_category_id' => $hotel->id,
            'vehicle_id'        => $vehicle->id,
            'perPersonPrice' => $perPersonPrice,
            'adultCount'     => $adultCount,
            'markupPercent'  => $markupPercent,
            'gstApplied'     => $request->has('add_gst'),
            'totalPrice'     => $totalPrice,
        ]
    ]);

    return back()->with([
        'totalPrice' => $totalPrice,
        'pdfToken'   => $token,
    ]);
}

   public function viewPdf($token)
{
    $data = session("quotation_$token");
    abort_if(!$data, 404);

    $package = Package::findOrFail($data['package_id']);
    $hotel   = HotelCategory::findOrFail($data['hotel_category_id']);
    $vehicle = Vehicle::findOrFail($data['vehicle_id']);

    $pdf = PDF::loadView('frontend.calculator.pdf', array_merge($data, [
        'package' => $package,
        'hotel'   => $hotel,
        'vehicle' => $vehicle,
    ]));

    return $pdf->stream('tour-quotation.pdf');
}

}