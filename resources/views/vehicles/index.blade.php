@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h4> Vehicles</h4>
            <a href="{{ route('vehicles.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus"></i> Add Vehicle
            </a>
        </div>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="bg-light">
                <tr>
                    <th>Sr. No</th>
                    <th>Vehicle Name</th>
                    <th>Capacity</th>
                    <th>Type</th>
                    <th>Rate</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $vehicle->name }}</td>
                        <td>{{ $vehicle->capacity }} Pax</td>
                        <td>
                            <span class="text-capitalize">{{ str_replace('_', ' ', $vehicle->type) }}</span>
                        </td>
                        <td>
                            @if ($vehicle->type === 'tour_basis')
                                <span class="text-muted small">Tour Basis</span>
                            @else
                                ₹{{ number_format($vehicle->price_per_day, 2) }}
                                <small class="text-muted">/ {{ $vehicle->type === 'per_day' ? 'day' : 'km' }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $vehicle->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $vehicle->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this vehicle?')" class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
