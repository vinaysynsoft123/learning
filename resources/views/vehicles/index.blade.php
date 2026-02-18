@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Vehicle Fleet</h3>
            <p class="text-muted mb-0">Manage your transport inventory and pricing models.</p>
        </div>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary shadow-sm rounded-3">
            <i class="bi bi-plus-circle me-2"></i>Add New Vehicle
        </a>
    </div>

    {{-- Vehicles Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 small text-uppercase py-3 ps-4">Vehicle Details</th>
                            <th class="border-0 small text-uppercase py-3">Capacity</th>
                            <th class="border-0 small text-uppercase py-3">Pricing Type</th>
                            <th class="border-0 small text-uppercase py-3">Base rate</th>
                            <th class="border-0 small text-uppercase py-3" width="120">Status</th>
                            <th class="border-0 small text-uppercase py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicles as $vehicle)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-info-soft rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="bi bi-car-front-fill text-info fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $vehicle->name }}</div>
                                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $vehicle->destination->name ?? 'Global' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-dark">{{ $vehicle->capacity }} Pax</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border py-1 px-3 rounded-pill small text-capitalize">
                                        {{ str_replace('_', ' ', $vehicle->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($vehicle->type === 'tour_basis')
                                        <span class="text-muted small">Multi-Point Rates</span>
                                    @else
                                        <div class="fw-bold text-dark">₹ {{ number_format($vehicle->price_per_day, 2) }}</div>
                                        <small class="text-muted">/ {{ $vehicle->type === 'per_day' ? 'day' : 'km' }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($vehicle->status)
                                        <span class="text-success small fw-bold"><i class="bi bi-circle-fill me-1 small"></i>Active</span>
                                    @else
                                        <span class="text-danger small fw-bold"><i class="bi bi-circle-fill me-1 small"></i>Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-none">
                                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-white btn-sm border-0 bg-transparent text-warning" title="Edit Vehicle">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-white btn-sm border-0 bg-transparent text-danger" 
                                                title="Delete Vehicle"
                                                onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                                <i class="bi bi-trash3-fill fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-truck display-4 d-block mb-3 opacity-25"></i>
                                    No vehicles configured in the fleet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .table-hover tbody tr:hover { background-color: rgba(13, 110, 253, 0.02); }
    .btn-white:hover { background-color: #f8f9fa; }
</style>
@endsection
