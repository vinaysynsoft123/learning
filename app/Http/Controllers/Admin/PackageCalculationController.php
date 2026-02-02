<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TourCalculationService;
use App\Models\User;
use App\Models\Destination;
use App\Models\Package;

class PackageCalculationController extends Controller
{
    protected $service;

    public function __construct(TourCalculationService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['agent_id', 'destination_id', 'package_id', 'travel_date']);

        $calculations = $this->service->listCalculations($filters);

        $agents       = User::where('role', 'agent')->get();
        $destinations = Destination::where('status', 1)->get();
        $packages     = Package::where('status', 1)->get();

        return view('package_calculations.index', compact('calculations', 'agents', 'destinations', 'packages'));
    }

    public function show($id)
    {
        $calculation = $this->service->getCalculation($id);

        return view('package_calculations.show', compact('calculation'));
    }
}
