@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-4">Package Calculator Reports</h4>

    <!-- Filters -->
    <form method="GET" class="row mb-4">

        <div class="col-md-3">
            <label class="form-label">Quotation No</label>
            <input type="text"
                name="unique_no"
                value="{{ request('unique_no') }}"
                class="form-control"
                placeholder="Enter Quotation No">
        </div>

        <div class="col-md-3">
            <label class="form-label">Agent</label>
            <select name="agent_id" class="form-select">
                <option value="">All Agents</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Destination</label>
            <select name="destination_id" class="form-select">
                <option value="">All Destinations</option>
                @foreach ($destinations as $destination)
                    <option value="{{ $destination->id }}" {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                        {{ $destination->name }}
                    </option>
                @endforeach
            </select>
        </div>
      

        <div class="col-md-3">
            <label class="form-label">Travel Date</label>
            <input type="date" name="travel_date" value="{{ request('travel_date') }}" class="form-control">
        </div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.package.calculations') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Quotation No</th>
                <th>Agent</th>
                <th>Destination</th>
                <th>Package</th>
                <th>Travel Date</th>
                <th>Pax</th>
                <th>Vehicle</th>
                <th>Total Price</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($calculations as $row)
                <tr>
                    <td>{{ $loop->iteration + ($calculations->currentPage() - 1) * $calculations->perPage() }}</td>
                    <td>{{ $row->unique_no }}</td>
                    <td>{{ $row->agent->name ?? 'Guest' }}</td>
                    <td>{{ $row->destination->name ?? '-' }}</td>
                    <td>{{ $row->package->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->travel_date)->format('d M Y') }}</td>
                    <td>{{ $row->total_pax }}</td>
                    <td>{{ $row->vehicle->name ?? '-' }}</td>
                    <td>₹ {{ number_format($row->total_price) }}</td>
                    <td>{{ $row->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.package.calculations.show', $row->id) }}"
                           class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-end custom-pagination">
        {{ $calculations->withQueryString()->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
