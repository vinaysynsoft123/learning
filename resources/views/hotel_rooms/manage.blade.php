@extends('layouts.app')

@section('content')
    <div class="container">

        <h4>{{ $roomType->id ? 'Edit Room Type' : 'Add Room Type' }}</h4>

        <form method="POST" action="{{ $roomType->id ? route('rooms.update', [$hotel->id, $roomType->id]) : route('hotel.rooms.store', $hotel->id) }}">

            @csrf
            @if ($roomType->id)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-4">
                    <label>Room Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $roomType->name) }}"
                        required>
                </div>

                <div class="col-md-4">
                    <label>Base Pax</label>
                    <input type="number" name="base_pax" class="form-control"
                        value="{{ old('base_pax', $roomType->base_pax) }}">
                </div>

                <div class="col-md-4">
                    <label>Max Pax</label>
                    <input type="number" name="max_pax" class="form-control"
                        value="{{ old('max_pax', $roomType->max_pax) }}">
                </div>


                <div class="col-md-4">
                    <label>Base Price</label>
                    <input type="number" name="base_price" class="form-control"
                        value="{{ old('base_price', $roomType->base_price) }}">
                </div>
                <div class="col-md-4">
                    <label>Extra Adult Price</label>
                    <input type="number" name="extra_adult_price" class="form-control"
                        value="{{ old('extra_adult_price', $roomType->extra_adult_price) }}">
                </div>

                <div class="col-md-4">
                    <label>Child with Bed Price</label>
                    <input type="number" name="child_with_bed_price" class="form-control"
                        value="{{ old('child_with_bed_price', $roomType->child_with_bed_price) }}">
                </div>

                <div class="col-md-4">
                    <label>Child No Bed Price</label>
                    <input type="number" name="child_no_bed_price" class="form-control"
                        value="{{ old('child_no_bed_price', $roomType->child_no_bed_price) }}">
                </div>
                <div class="col-md-4">
                    <label>Infant Price</label>
                    <input type="number" name="infant_price" class="form-control"
                        value="{{ old('infant_price', $roomType->infant_price) }}">
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Season Start</label>
                    <input type="date" name="season_start" class="form-control"
                        value="{{ old('season_start', optional($roomType->season_start)->format('Y-m-d')) }}">
                </div>

                <div class="col-md-4">
                    <label>Season End</label>
                    <input type="date" name="season_end" class="form-control"
                        value="{{ old('season_end', optional($roomType->season_end)->format('Y-m-d')) }}">
                </div>

                <div class="col-md-4">
                    <label>Season Base Price</label>
                    <input type="number" name="season_base_price" class="form-control"
                        value="{{ old('season_base_price', $roomType->season_base_price) }}">
                </div>

                <div class="col-md-4">
                    <label>Season Extra Adult Price</label>
                    <input type="number" name="season_extra_adult_price" class="form-control"
                        value="{{ old('season_extra_adult_price', $roomType->season_extra_adult_price) }}">
                </div>

                <div class="col-md-4">
                    <label>Season child with bed price</label>
                    <input type="number" name="season_child_with_bed_price" class="form-control"
                        value="{{ old('season_child_with_bed_price', $roomType->season_child_with_bed_price) }}">
                </div>

                <div class="col-md-4">
                    <label>Season child no bed price</label>
                    <input type="number" name="season_child_no_bed_price" class="form-control"
                        value="{{ old('season_child_no_bed_price', $roomType->season_child_no_bed_price) }}">
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col-md-4">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $roomType->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $roomType->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>

            <button class="btn btn-success">
                {{ $roomType->id ? 'Update' : 'Save' }}
            </button>

            <a href="{{ route('rooms.index', $hotel->id) }}" class="btn btn-secondary">
                Back
            </a>
        </form>

    </div>
@endsection
