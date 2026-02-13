@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
    <h3>{{ isset($category) ? 'Edit Hotel Category' : 'Add Hotel Category' }}</h3>

    <form method="POST"
          action="{{ isset($category)
            ? route('hotel-categories.update', $category)
            : route('hotel-categories.store') }}">

        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $category->name ?? '') }}" required>
                   @error('name')
                   <span class="text-danger">{{ $message }}</span>
               @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" @selected(old('status', $category->status ?? 1) == 1)>Active</option>
                <option value="0" @selected(old('status', $category->status ?? 1) == 0)>Inactive</option>
            </select>
        </div>

        <button class="btn btn-success">
            {{ isset($category) ? 'Update' : 'Save' }}
        </button>

        <a href="{{ route('hotel-categories.index') }}" class="btn btn-secondary">
            Back
        </a>
    </form>
</div>
</div>
</div>
@endsection
