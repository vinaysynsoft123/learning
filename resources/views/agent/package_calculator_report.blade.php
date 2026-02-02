@extends('frontend.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row g-4 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Package Calculation Reports</h3>
            </div>
            <div class="card shadow-sm border-0 mb-4">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sr No</th>
                                <th>Quotation No</th>
                                <th>Destination</th>
                                <th>Themes</th>
                                <th>Packages</th>
                                <th>Travel Date</th>
                                <th>Pax</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->unique_no }}</td>
                                    <td>{{ $row->destination->name ?? '-' }}</td>
                                    <td>{{ $row->theme->name ?? '-' }}</td>
                                    <td>{{ $row->package->name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->travel_date)->format('d M Y') }}</td>
                                    <td>{{ $row->total_pax }}</td>
                                    <td>₹ {{ number_format($row->total_price) }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
