@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit User</h3>

       <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" readonly>
            </div>

            <div class="mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_verify" value="1" class="form-check-input" id="is_verify"
                    {{ old('is_verify', $user->is_verify) ? 'checked' : '' }}>

                <label class="form-check-label" for="is_verify">
                    Mobile Verified
                </label>
            </div>
             <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="Staff" @selected($user->role == 'Staff')>Staff</option>
                    <option value="Freelancer" @selected($user->role == 'Freelancer')>Freelancer</option>
                    <option value="Agent" @selected($user->role == 'Agent')>Agent</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" @selected($user->status == 1)>Active</option>
                    <option value="0" @selected($user->status == 0)>Inactive</option>
                </select>
            </div>

            <hr>

            <div class="mb-3">
                <label>Password <small>(leave blank to keep same)</small></label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button class="btn btn-primary">Update</button>

        </form>
    </div>
@endsection
