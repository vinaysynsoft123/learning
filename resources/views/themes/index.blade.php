@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h4> Themes</h4>
            <a href="{{ route('themes.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus"></i> Add Theme
            </a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <!-- <th>Destination</th> -->
                    <th>Theme Name</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($themes as $theme)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <!-- <td>{{ $theme->destination->name ?? '-' }}</td> -->
                        <td>{{ $theme->name }}</td>
                        <td>
                            <span class="badge {{ $theme->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $theme->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('themes.edit', $theme) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('themes.destroy', $theme) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this theme?')" class="btn btn-danger btn-sm">
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
