@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">{{ isset($vehicle) ? 'Edit Vehicle' : 'Add New Vehicle' }}</h3>
            <p class="text-muted mb-0">Configure your vehicle's technical specifications and pricing models.</p>
        </div>
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary shadow-sm rounded-3">
            <i class="bi bi-arrow-left me-2"></i>Back to Fleet
        </a>
    </div>

    <form method="POST" action="{{ isset($vehicle) ? route('vehicles.update', $vehicle) : route('vehicles.store') }}">
        @csrf
        @if (isset($vehicle))
            @method('PUT')
        @endif

        <div class="row g-4">
            {{-- Vehicle Specifications --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-truck me-2 text-primary"></i>Vehicle Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold small text-uppercase">Vehicle Display Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-car-front"></i></span>
                                    <input type="text" name="name" class="form-control border-0 bg-light px-3" 
                                           value="{{ old('name', $vehicle->name ?? '') }}" placeholder="e.g. Toyota Innova Hycross" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">Primary Destination</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt"></i></span>
                                    <select name="destination_id" class="form-select border-0 bg-light" required>
                                        <option value="">Select Location</option>
                                        @foreach ($destinations as $destination)
                                            <option value="{{ $destination->id }}"
                                                {{ old('destination_id', $vehicle->destination_id ?? '') == $destination->id ? 'selected' : '' }}>
                                                {{ $destination->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">Passenger Capacity (Pax)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-people"></i></span>
                                    <input type="number" name="capacity" class="form-control border-0 bg-light px-3" 
                                           value="{{ old('capacity', $vehicle->capacity ?? '') }}" placeholder="Max Seats" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small text-uppercase">Operational Status</label>
                                <div class="d-flex gap-4 p-3 bg-light rounded-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_active" value="1" @checked(old('status', $vehicle->status ?? 1) == 1)>
                                        <label class="form-check-label text-success fw-bold" for="status_active">Active Fleet</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0" @checked(old('status', $vehicle->status ?? 1) == 0)>
                                        <label class="form-check-label text-danger fw-bold" for="status_inactive">Under Maintenance</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pricing Configuration --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex align-items-center">
                        <div class="bg-warning-soft rounded-3 p-2 me-3">
                            <i class="bi bi-currency-dollar text-warning"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Pricing Model</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-uppercase">Revenue Type</label>
                            <select name="type" id="vehicle_type" class="form-select border-0 bg-light py-3 px-4 fw-bold text-primary" required>
                                <option value="per_day" @selected(old('type', $vehicle->type ?? 'per_day') == 'per_day')>Standard: Daily Rate</option>
                                <option value="per_km" @selected(old('type', $vehicle->type ?? 'per_day') == 'per_km')>Usage: Per KM Basis</option>
                                <option value="tour_basis" @selected(old('type', $vehicle->type ?? 'per_day') == 'tour_basis')>Advanced: Multi-Point Rates</option>
                            </select>
                        </div>

                        <div id="rate_field" class="mb-4 animate__animated animate__fadeIn" style="display: none;">
                            <label class="form-label fw-semibold small text-uppercase" id="rate_label">Price Per Day</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 shadow-sm px-4 fw-bold">₹</span>
                                <input type="number" step="0.01" name="price_per_day" class="form-control border-0 shadow-sm py-3 px-4 fw-bold text-success fs-4"
                                       value="{{ old('price_per_day', $vehicle->price_per_day ?? '') }}" placeholder="0.00">
                            </div>
                        </div>

                        <div id="tour_basis_field" class="mb-4 animate__animated animate__fadeIn" style="display: none;">
                            <label class="form-label fw-semibold small text-uppercase">Multi-Point Rate Sheet</label>
                            <div class="p-4 bg-light rounded-4 border-start border-primary border-4">
                                <textarea name="tour_rates" class="form-control border-0 bg-transparent text-dark" rows="8" 
                                          placeholder="Ex: Source Goa 1500&#10;Airport Drop 2000">{{ old('tour_rates', $vehicle->tour_rates ?? '') }}</textarea>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i> Format: [Description] [Amount]. Enter one route per line.
                            </small>
                        </div>

                        <div class="alert alert-info border-0 shadow-sm rounded-4 py-3 d-flex align-items-center">
                            <i class="bi bi-shield-check fs-3 me-3 opacity-50"></i>
                            <div class="small">Rates are used automatically during tour calculations for selected destinations.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 text-end">
                <hr class="my-4 opacity-10">
                <button type="submit" class="btn btn-primary px-5 py-3 shadow-sm rounded-pill">
                    <i class="bi bi-check2-circle me-2"></i>{{ isset($vehicle) ? 'Update Fleet Record' : 'Commit to Fleet' }}
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: none !important;
    }
    .input-group-text { color: #6c757d; }
    .card { border-radius: 12px; }
</style>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('vehicle_type');
            const rateField = document.getElementById('rate_field');
            const rateLabel = document.getElementById('rate_label');
            const tourField = document.getElementById('tour_basis_field');

            function toggleFields() {
                const type = typeSelect.value;
                if (type === 'tour_basis') {
                    rateField.style.display = 'none';
                    tourField.style.display = 'block';
                } else {
                    rateField.style.display = 'block';
                    tourField.style.display = 'none';
                    rateLabel.innerText = type === 'per_day' ? 'Standard Daily Rate' : 'Price Per Kilometre';
                }
            }

            typeSelect.addEventListener('change', toggleFields);
            toggleFields();
        });
    </script>
@endsection
@endsection

