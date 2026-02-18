@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">User Profile Details</h3>
            <p class="text-muted mb-0">Detailed view of user account and associated company information.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-primary shadow-sm rounded-3">
            <i class="bi bi-arrow-left me-2"></i>Back to Users
        </a>
    </div>

    <div class="row g-4">
        {{-- User Identity & Account Details --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="avatar-container bg-primary-soft rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                            <span class="display-4 fw-bold text-primary">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        @if($user->status)
                            <span class="position-absolute bottom-0 end-0 bg-success border border-white border-3 rounded-circle" style="width: 18px; height: 18px;" title="Active"></span>
                        @else
                            <span class="position-absolute bottom-0 end-0 bg-danger border border-white border-3 rounded-circle" style="width: 18px; height: 18px;" title="Inactive"></span>
                        @endif
                    </div>
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <span class="badge {{ $user->role == 'Admin' ? 'bg-danger' : 'bg-primary' }} bg-opacity-10 text-{{ $user->role == 'Admin' ? 'danger' : 'primary' }} rounded-pill px-3 py-1 small mb-3">
                        {{ ucfirst($user->role) }}
                    </span>
                    
                    <div class="text-start mt-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold mb-1">Email Address</label>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-envelope text-primary me-2"></i>
                                <span class="fw-medium text-dark">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold mb-1">Account Status</label>
                            <div>
                                @if($user->status)
                                    <span class="text-success fw-bold small"><i class="bi bi-check-circle-fill me-1"></i>Active Account</span>
                                @else
                                    <span class="text-danger fw-bold small"><i class="bi bi-x-circle-fill me-1"></i>Inactive Account</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label text-muted small text-uppercase fw-bold mb-1">Last Activity</label>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock-history text-muted me-2"></i>
                                <span class="small text-muted">{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->diffForHumans() : 'Never logged in' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats Box --}}
            <div class="card border-0 shadow-sm bg-primary text-white p-4">
                <h6 class="text-white-50 small text-uppercase fw-bold mb-3">Quick Overview</h6>
                <div class="d-flex justify-content-between align-items-center mb-0">
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $user->tour_calculations_count ?? 0 }}</h3>
                        <span class="small opacity-75">Tour Calculations</span>
                    </div>
                    <i class="bi bi-calculator display-6 opacity-25"></i>
                </div>
            </div>
        </div>

        {{-- Company Details Section --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex align-items-center">
                    <div class="bg-warning-soft rounded-3 p-2 me-3">
                        <i class="bi bi-building text-warning fs-5"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Company Information</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    @if ($user->company)
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-1">Official Company Name</label>
                                <div class="p-3 bg-light rounded-3 fw-bold text-dark border-start border-warning border-4">
                                    {{ $user->company->company_name }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-1">Company Contact Email</label>
                                <div class="p-3 bg-light rounded-3 text-dark">
                                    <i class="bi bi-envelope-at me-2 text-muted"></i>{{ $user->company->email ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-1">Primary Mobile Number</label>
                                <div class="p-3 bg-light rounded-3 text-dark">
                                    <i class="bi bi-phone me-2 text-muted"></i>{{ $user->company->mobile ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-1">City / Region</label>
                                <div class="p-3 bg-light rounded-3 text-dark">
                                    <i class="bi bi-geo-alt me-2 text-muted"></i>{{ $user->company->city ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-1">Registered Business Address</label>
                                <div class="p-3 bg-light rounded-3 text-dark">
                                    <i class="bi bi-building-up me-2 text-muted"></i>{{ $user->company->address ?? 'Not Provided' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-1">GST Identification Number</label>
                                <div class="p-3 bg-light rounded-3 text-dark">
                                    <code class="text-primary fw-bold">{{ $user->company->gst_number ?? 'N/A' }}</code>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-1">PAN Directory Number</label>
                                <div class="p-3 bg-light rounded-3 text-dark">
                                    <code class="text-primary fw-bold">{{ $user->company->pan_number ?? 'N/A' }}</code>
                                </div>
                            </div>

                            @if ($user->company->logo)
                                <div class="col-12">
                                    <label class="form-label text-muted small text-uppercase fw-bold mb-2">Company Branding (Logo)</label>
                                    <div class="bg-light rounded-4 p-4 text-center border" style="max-width: 250px;">
                                        <img src="{{ asset('storage/' . $user->company->logo) }}" alt="Company Logo" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                <i class="bi bi-building-slash display-4 text-muted"></i>
                            </div>
                            <h5 class="text-muted">No Company Details Linked</h5>
                            <p class="small text-muted">This user has not provided their business information yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .avatar-container { border: 3px solid #fff; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1); }
    .card { border-radius: 12px; }
</style>
@endsection
