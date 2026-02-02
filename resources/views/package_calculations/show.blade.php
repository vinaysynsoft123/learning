@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Quotation {{ $calculation->unique_no }}</h4>

    <div class="card">
        <div class="card-body">

            <p><strong>Agent:</strong> {{ $calculation->agent->name ?? 'Guest' }}</p>
            <p><strong>Destination:</strong> {{ $calculation->destination->name }}</p>
            <p><strong>Package:</strong> {{ $calculation->package->name }}</p>
            <p><strong>Hotel Category:</strong> {{ $calculation->hotelCategory->name }}</p>
            <p><strong>Vehicle:</strong> {{ $calculation->vehicle->name }}</p>
            <p><strong>Total Pax:</strong> {{ $calculation->total_pax }}</p>
            <p><strong>Travel Date:</strong> {{ $calculation->travel_date }}</p>

            <hr>

            <p><strong>Markup:</strong> {{ $calculation->markup }}%</p>
            <p><strong>GST Applied:</strong> {{ $calculation->gst_applied ? 'Yes' : 'No' }}</p>
            <p class="fs-5 fw-bold">
                Total Price: ₹ {{ number_format($calculation->total_price) }}
            </p>

        </div>
    </div>

</div>
@endsection
