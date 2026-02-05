@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row col-md-8">
            <h3>{{ isset($hotel) ? 'Edit Hotel ' : 'Add Hotel ' }}</h3>

            <form method="POST" action="{{ isset($hotel) ? route('hotels.update', $hotel) : route('hotels.store') }}">

                @csrf
                @if (isset($hotel))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <label> Hotel Categories</label>
                    <select name="hotel_category_id" class="form-select">
                        @foreach ($categories as $hotel_category)
                            <option value="{{ $hotel_category->id }}" @selected(old('hotel_category_id', $hotel->hotel_category_id ?? '') == $hotel_category->id)>
                                {{ $hotel_category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="state" value="1">
                <div class="mb-3">
                    <label> Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $hotel->name ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label> City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('name', $hotel->city ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" @selected(old('status', $hotel->status ?? 1) == 1)>Active</option>
                        <option value="0" @selected(old('status', $hotel->status ?? 1) == 0)>Inactive</option>
                    </select>
                </div>

                <button class="btn btn-success">
                    {{ isset($hotel) ? 'Update' : 'Save' }}
                </button>
            </form>
        </div>
    </div>
@endsection
