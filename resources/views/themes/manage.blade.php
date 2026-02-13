@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
    <h3>{{ isset($theme) ? 'Edit Theme' : 'Add Theme' }}</h3>

    <form method="POST"
          action="{{ isset($theme)
            ? route('themes.update', $theme)
            : route('themes.store') }}">

        @csrf
        @if(isset($theme))
            @method('PUT')
        @endif

        <input type="hidden" name="destination_id" value="1">
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
</div>
</div>
@endsection
