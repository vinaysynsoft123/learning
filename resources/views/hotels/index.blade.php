@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h4>Hotel </h4>
            <a href="{{ route('hotels.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus"></i> Add Hotel
            </a>
        </div>
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="city" value="{{ request('city') }}" class="form-control"
                    placeholder="Search City">
            </div>

            <div class="col-md-3">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="1" @selected(request('status') === '1')>Active</option>
                    <option value="0" @selected(request('status') === '0')>Inactive</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('hotels.index') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SR No</th>
                    <th>
                        <a
                            href="{{ route(
                                'hotels.index',
                                array_merge(request()->query(), [
                                    'sort_by' => 'name',
                                    'sort_dir' => request('sort_dir') == 'asc' ? 'desc' : 'asc',
                                ]),
                            ) }}">
                            Name
                            @if (request('sort_by') == 'name')
                                <i class="bi bi-arrow-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>

                    <th>
                        <a
                            href="{{ route(
                                'hotels.index',
                                array_merge(request()->query(), [
                                    'sort_by' => 'city',
                                    'sort_dir' => request('sort_dir') == 'asc' ? 'desc' : 'asc',
                                ]),
                            ) }}">
                            Destination
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route(
                                'hotels.index',
                                array_merge(request()->query(), [
                                    'sort_by' => 'status',
                                    'sort_dir' => request('sort_dir') == 'asc' ? 'desc' : 'asc',
                                ]),
                            ) }}">
                            Status
                        </a>
                    </th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hotels as $hotel)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $hotel->name }}</td>
                        <td>{{ $hotel->city }}</td>
                        <td>
                            <span class="badge {{ $hotel->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $hotel->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('rooms.index', $hotel->id) }}" class="btn btn-info btn-sm">
                                Rooms
                            </a>

                            <a href="{{ route('hotels.edit', $hotel) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('hotels.destroy', $hotel) }}" method="POST" class="d-inline">
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
        <!-- Pagination -->
        <div class="d-flex justify-content-end custom-pagination">
            {{ $hotels->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
