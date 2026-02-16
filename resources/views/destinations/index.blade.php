@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h4>Destinations</h4>
            <a href="{{ route('destinations.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus"></i> Add Destination
            </a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Destionation Name</th>
                    <th>State</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($destinations as $destination)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $destination->name }}</td>
                        <td>{{ $destination->state->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ ucfirst($destination->type) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge {{ $destination->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $destination->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('destinations.edit', $destination) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('destinations.destroy', $destination) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this destination?')" class="btn btn-sm btn-danger">
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
