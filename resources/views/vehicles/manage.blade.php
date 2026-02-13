@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">           
              
                        <h4 class="mb-0">{{ isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle' }}</h4>
                                
                        <form method="POST"
                            action="{{ isset($vehicle) ? route('vehicles.update', $vehicle) : route('vehicles.store') }}">
                            @csrf
                            @if (isset($vehicle))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Destination</label>
                                <select name="destination_id" class="form-select" required>
                                    <option value="">Select Destination</option>
                                    @foreach ($destinations as $destination)
                                        <option value="{{ $destination->id }}"
                                            {{ old('destination_id', $vehicle->destination_id ?? '') == $destination->id ? 'selected' : '' }}>
                                            {{ $destination->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vehicle Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $vehicle->name ?? '') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Capacity (Pax)</label>
                                    <input type="number" name="capacity" class="form-control"
                                        value="{{ old('capacity', $vehicle->capacity ?? '') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Type</label>
                                    <select name="type" id="vehicle_type" class="form-select" required>
                                        <option value="per_day" @selected(old('type', $vehicle->type ?? 'per_day') == 'per_day')>Per Day</option>
                                        <option value="per_km" @selected(old('type', $vehicle->type ?? 'per_day') == 'per_km')>Per KM</option>
                                        <option value="tour_basis" @selected(old('type', $vehicle->type ?? 'per_day') == 'tour_basis')>Tour Basis</option>
                                    </select>
                                </div>
                            </div>

                            <div id="rate_field" class="mb-3">
                                <label class="form-label" id="rate_label">Rate</label>
                                <input type="number" step="0.01" name="price_per_day" class="form-control"
                                    value="{{ old('price_per_day', $vehicle->price_per_day ?? '') }}">
                            </div>

                            <div id="tour_basis_field" class="mb-3" style="display: none;">
                                <label class="form-label">Tour Basis Rates</label>
                                <textarea name="tour_rates" class="form-control" rows="4" placeholder="Ex: Source Goa 1500&#10;Naroth Goa 2000">{{ old('tour_rates', $vehicle->tour_rates ?? '') }}</textarea>
                                <small class="text-muted">Enter rates line by line.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" @selected(old('status', $vehicle->status ?? 1) == 1)>Active</option>
                                    <option value="0" @selected(old('status', $vehicle->status ?? 1) == 0)>Inactive</option>
                                </select>
                            </div>

                            <div class="border-top pt-3">
                                <button class="btn btn-success px-4">
                                    {{ isset($vehicle) ? 'Update' : 'Save' }}
                                </button>
                                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary px-4">
                                    Back
                                </a>
                            </div>
                        </form>                 
        
            </div>
        </div>
    </div>
@endsection

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
                    rateLabel.innerText = type === 'per_day' ? 'Price Per Day' : 'Price Per KM';
                }
            }

            typeSelect.addEventListener('change', toggleFields);
            toggleFields(); // Initial call
        });
    </script>
@endsection

