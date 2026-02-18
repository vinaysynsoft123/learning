@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">My Account</h3>
            <p class="text-muted mb-0">Manage your personal information and security settings.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        {{-- Profile Identity Card --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm text-center p-4">
                <div class="card-body">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="avatar-container bg-primary-soft rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px;">
                            <span class="display-3 fw-bold text-primary">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white border-3 rounded-circle" style="width: 20px; height: 20px;"></span>
                    </div>
                    <h4 class="fw-bold mb-1">{{ auth()->user()->name }}</h4>
                    <p class="text-muted small mb-3">{{ auth()->user()->role }} • Member since {{ auth()->user()->created_at->format('M Y') }}</p>
                    
                    <div class="d-grid gap-2 border-top pt-3">
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">Account Status</span>
                            <span class="badge bg-success-soft text-success px-2 py-1">Active</span>
                        </div>
                        <div class="d-flex justify-content-between small">
                            <span class="text-muted">Last Login</span>
                            <span class="fw-semibold">{{ auth()->user()->last_login ? auth()->user()->last_login->diffForHumans() : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Update Forms --}}
        <div class="col-lg-8">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Personal Information --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-person-fill me-2 text-primary"></i>Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control border-0 bg-light px-3" value="{{ auth()->user()->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-0 bg-light px-3" value="{{ auth()->user()->email }}" readonly>
                                </div>
                                <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle me-1"></i>Email cannot be changed.</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Security Section --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-shield-lock-fill me-2 text-warning"></i>Security & Password</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control border-0 bg-light px-3" placeholder="Leave blank to keep current">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock-check"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control border-0 bg-light px-3" placeholder="Confirm your new password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm rounded-3">
                        <i class="bi bi-check2-circle me-2"></i>Save Profile Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: none !important;
    }
    
    .input-group-text {
        color: #6c757d;
    }
    
    .card {
        border-radius: 12px;
        transition: transform 0.2s ease-in-out;
    }
    
    .avatar-container {
        border: 4px solid #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
