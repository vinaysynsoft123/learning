@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Add User</h3>

        <form action="{{ route('users.save') }}" method="POST">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_verify" value="1" class="form-check-input" id="is_verify"
                    {{ old('is_verify') ? 'checked' : '' }}>

                <label class="form-check-label" for="is_verify">
                    Verified
                </label>
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="Staff">Staff</option>
                    <option value="Freelancer">Freelancer</option>
                    <option value="Agent">Agent</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <hr>
            <div class="mb-3">
                <label>Password </label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button class="btn btn-primary">Save</button>

        </form>
    </div>
@endsection
