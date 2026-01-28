@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h4>Hotel Categories</h4>
            <a href="{{ route('hotel-categories.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus"></i> Add Category
            </a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SR No</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <span class="badge {{ $category->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('hotel-categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('hotel-categories.destroy', $category) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this category?')" class="btn btn-danger btn-sm">
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
