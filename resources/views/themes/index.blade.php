@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Package Themes</h3>
            <p class="text-muted mb-0">Categorize your travel packages into engaging themes like Honeymoon, Adventure, or Leisure.</p>
        </div>
        <a href="{{ route('themes.create') }}" class="btn btn-primary shadow-sm rounded-3">
            <i class="bi bi-tag-fill me-2"></i>Create New Theme
        </a>
    </div>

    {{-- Themes Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 small text-uppercase py-3 ps-4" width="80">#</th>
                            <th class="border-0 small text-uppercase py-3">Theme Name</th>
                            <th class="border-0 small text-uppercase py-3 text-center" width="150">Status</th>
                            <th class="border-0 small text-uppercase py-3 text-end pe-4" width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($themes as $theme)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-muted">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary-soft rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-palette2 text-primary"></i>
                                        </div>
                                        <div class="fw-bold text-dark">{{ $theme->name }}</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($theme->status)
                                        <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill small">
                                            <i class="bi bi-check-circle-fill me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger px-3 py-2 rounded-pill small">
                                            <i class="bi bi-x-circle-fill me-1"></i>Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('themes.edit', $theme) }}" class="btn btn-outline-warning btn-sm border-0" title="Edit Theme">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                        <form action="{{ route('themes.destroy', $theme) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-outline-danger btn-sm border-0" 
                                                title="Delete Theme"
                                                onclick="return confirm('Are you sure you want to delete this theme?')">
                                                <i class="bi bi-trash3-fill fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-tags display-4 d-block mb-3 opacity-25"></i>
                                    No themes configured yet. Start by creating one!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .table-hover tbody tr:hover { background-color: rgba(13, 110, 253, 0.02); }
    .card { border-radius: 12px; }
</style>
@endsection
