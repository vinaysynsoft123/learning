@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('destinations.store') }}" method="POST">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Destionation Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="">Select Destination Type</option>

                            <option value="domestic" @selected(old('type', $destination->type ?? '') == 'domestic')>
                                Domestic
                            </option>

                            <option value="international" @selected(old('type', $destination->type ?? '') == 'international')>
                                International
                            </option>
                        </select>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Destination Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $destination->name ?? '') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3" id="state-wrapper">
                        <label>State</label>
                        <select name="state_id" id="state_id" class="form-control">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" @selected(old('state_id', $destination->state_id ?? '') == $state->id)>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" @selected(old('status', $destination->status ?? 1) == 1)>Active</option>
                            <option value="0" @selected(old('status', $destination->status ?? 1) == 0)>Inactive</option>
                        </select>
                    </div>
                    <button class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function toggleStateField() {
        let type = document.getElementById('type').value;
        let stateWrapper = document.getElementById('state-wrapper');
        let stateField = document.getElementById('state_id');

        if (type === 'international') {
            stateWrapper.style.display = 'none';
            stateField.value = '';
            stateField.removeAttribute('required');
        } else {
            stateWrapper.style.display = 'block';
            stateField.setAttribute('required', 'required');
        }
    }

    document.getElementById('type').addEventListener('change', toggleStateField);
    toggleStateField();
});
</script>
@endsection
