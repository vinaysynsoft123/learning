@extends('layouts.app')

@section('content')
    <form action="{{ route('destinations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>State</label>
            <select name="state_id" class="form-control" required>
                <option value="">Select State</option>
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" @selected(old('state_id', $destination->state_id ?? '') == $state->id)>
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Destination Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $destination->name ?? '') }}"
                required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" @selected(old('status', $destination->status ?? 1) == 1)>Active</option>
                <option value="0" @selected(old('status', $destination->status ?? 1) == 0)>Inactive</option>
            </select>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
  
@endsection
