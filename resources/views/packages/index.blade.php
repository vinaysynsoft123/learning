@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h4>Packages </h4>
            <a href="{{ route('packages.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus"></i> Add Package
            </a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Destination</th>
                    <th>Theme</th>
                    <th>Name</th>
                    <th>Nights</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th width="180">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $package->destination->name ?? '-' }}</td>
                        <td>{{ $package->theme->name ?? '-' }}</td>
                        <td>{{ $package->name }}</td>
                        <td>{{ $package->nights }}</td>
                        <td>{{ $package->base_price }}</td>
                        <td>
                            <span class="badge bg-{{ $package->status ? 'success' : 'danger' }}">
                                {{ $package->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('packages.edit', $package) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('packages.destroy', $package) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this package?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
   <!-- Pagination -->
    <div class="d-flex justify-content-end custom-pagination">
        {{ $packages->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    </div>
@endsection
