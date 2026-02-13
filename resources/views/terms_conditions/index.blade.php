@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h4>Terms & Conditions</h4>
            <a href="{{ route('terms-conditions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Add New
            </a>
        </div>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="bg-light">
                <tr>
                    <th>Sr. No</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($terms as $term)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $term->destination->name ?? 'Global (All)' }}</td>
                        <td>
                            <span class="badge {{ $term->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $term->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('terms-conditions.edit', $term) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('terms-conditions.destroy', $term) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this record?')" class="btn btn-sm btn-danger">
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
