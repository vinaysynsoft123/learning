@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{ isset($package) ? 'Edit Package' : 'Add Package' }}</h3>
        <form method="POST" action="{{ isset($package) ? route('packages.update', $package) : route('packages.store') }}">
            @csrf
            @isset($package)
                @method('PUT')
            @endisset

            <div class="mb-3">
                <label>Theme</label>
                <select name="theme_id" class="form-control" required>
                    <option value="">Select Theme</option>
                    @foreach ($themes as $theme)
                        <option value="{{ $theme->id }}" @selected(old('theme_id', $package->theme_id ?? '') == $theme->id)>
                            {{ $theme->destination->name ?? '' }} → {{ $theme->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Package Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $package->name ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Nights</label>
                <input type="number" name="nights" class="form-control"
                    value="{{ old('nights', $package->nights ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label>Base Price</label>
                <input type="number" step="0.01" name="base_price" class="form-control"
                    value="{{ old('base_price', $package->base_price ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description', $package->description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Discount</label>
                <input type="number" step="0.01" name="discount" class="form-control"
                    value="{{ old('discount', $package->discount ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" @selected(old('status', $package->status ?? 1) == 1)>Active</option>
                    <option value="0" @selected(old('status', $package->status ?? 1) == 0)>Inactive</option>
                </select>
            </div>

            <button class="btn btn-success">Save</button>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">Back</a>
        </form>

    </div>
@endsection

//mujhe hotel nhi destiona decide krna hai ki day me staty kaha hoga aur day 2 me kaha 