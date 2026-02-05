@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h4> Users </h4>
            <a href="{{ route('users.create')}}" class="btn btn-primary mb-3">
                <i class="bi bi-plus"></i> Add Users
            </a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>                     

                        <td>
                            <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td class="d-flex gap-2">
                           <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                           <a href="{{ route('users.show', $user) }}" class="btn btn-warning btn-sm">View</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button 
                            onclick="return confirm('WARNING: This action will permanently delete this user and ALL associated data from the database. This cannot be undone. Do you want to proceed?')"
                            class="btn btn-danger btn-sm">
                            Delete
                        </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
