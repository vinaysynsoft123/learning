@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ isset($theme) ? 'Edit Theme' : 'Add Theme' }}</h3>

    <form method="POST"
          action="{{ isset($theme)
            ? route('themes.update', $theme)
            : route('themes.store') }}">

        @csrf
        @if(isset($theme))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Destination</label>
            <select name="destination_id" class="form-control" required>
                <option value="">Select Destination</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}"
                        @selected(old('destination_id', $theme->destination_id ?? '') == $destination->id)>
                        {{ $destination->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Theme Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $theme->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" @selected(old('status', $theme->status ?? 1) == 1)>Active</option>
                <option value="0" @selected(old('status', $theme->status ?? 1) == 0)>Inactive</option>
            </select>
        </div>

        <button class="btn btn-success">
            {{ isset($theme) ? 'Update' : 'Save' }}
        </button>

        <a href="{{ route('themes.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
