@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle' }}</h3>

        <form method="POST" action="{{ isset($vehicle) ? route('vehicles.update', $vehicle) : route('vehicles.store') }}">

            @csrf
            @if (isset($vehicle))
                @method('PUT')
            @endif

            <input type="hidden" name="other" name="other" value="1">
            <div class="mb-3">
                <label>Destination Name</label>
                <select name="destination_id" class="form-select">
                    <option value="">Select Destination</option>
                    @foreach ($destinations as $destination)
                        <option value="{{ $destination->id }}"
                            {{ old('destination_id', $vehicle->destination_id) == $destination->id ? 'selected' : '' }}>
                            {{ $destination->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Vehicle Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $vehicle->name ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Capacity</label>
                <input type="number" name="capacity" class="form-control"
                    value="{{ old('capacity', $vehicle->capacity ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label>Price Per Day</label>
                <input type="number" step="0.01" name="price_per_day" class="form-control"
                    value="{{ old('price_per_day', $vehicle->price_per_day ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" @selected(old('status', $vehicle->status ?? 1) == 1)>Active</option>
                    <option value="0" @selected(old('status', $vehicle->status ?? 1) == 0)>Inactive</option>
                </select>
            </div>

            <button class="btn btn-success">
                {{ isset($vehicle) ? 'Update' : 'Save' }}
            </button>

            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                Back
            </a>
        </form>
    </div>
@endsection
