@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">User Management</h3>
            <p class="text-muted mb-0">List and manage all system users, including staff and agents.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm rounded-3">
            <i class="bi bi-person-plus me-2"></i>Add New User
        </a>
    </div>

    {{-- Users Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 small text-uppercase py-3 ps-4">User Details</th>
                            <th class="border-0 small text-uppercase py-3">Contact</th>
                            <th class="border-0 small text-uppercase py-3">Role</th>
                            <th class="border-0 small text-uppercase py-3" width="120">Status</th>
                            <th class="border-0 small text-uppercase py-3">Joined On</th>
                            <th class="border-0 small text-uppercase py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary-soft rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="fw-bold text-primary">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-medium">{{ $user->mobile ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $user->role == 'Admin' ? 'bg-danger' : ($user->role == 'Agent' ? 'bg-primary' : 'bg-info') }} bg-opacity-10 text-{{ $user->role == 'Admin' ? 'danger' : ($user->role == 'Agent' ? 'primary' : 'info') }} py-1 px-3 rounded-pill small">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->status)
                                        <span class="text-success small fw-bold"><i class="bi bi-circle-fill me-1 small"></i>Active</span>
                                    @else
                                        <span class="text-danger small fw-bold"><i class="bi bi-circle-fill me-1 small"></i>Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small text-muted">{{ $user->created_at->format('d M Y') }}</div>
                                    <div class="small opacity-75">{{ $user->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-none">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-white btn-sm border-0 bg-transparent text-primary" title="View Details">
                                            <i class="bi bi-eye-fill fs-5"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-white btn-sm border-0 bg-transparent text-warning" title="Edit User">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-white btn-sm border-0 bg-transparent text-danger" 
                                                title="Delete User"
                                                onclick="return confirm('WARNING: This action will permanently delete this user and ALL associated data. Do you want to proceed?')">
                                                <i class="bi bi-trash3-fill fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people display-4 d-block mb-3 opacity-25"></i>
                                    No users found in the system.
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
    .table-hover tbody tr:hover { background-color: rgba(13, 110, 253, 0.02); }
    .btn-white:hover { background-color: #f8f9fa; }
</style>
@endsection
