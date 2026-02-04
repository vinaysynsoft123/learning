@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <!-- USER DETAILS -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">User Details</h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="text-muted small">Name</label>
                                <div class="fw-medium">{{ $user->name }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Email</label>
                                <div class="fw-medium">{{ $user->email }}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="text-muted small">Role</label><br>
                                <span class="badge bg-light text-dark border">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>

                            <div class="col-md-4">
                                <label class="text-muted small">Status</label><br>
                                @if ($user->status)
                                    <span class="badge bg-success-subtle text-success border border-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small">Status</label><br>
                               <div class="fw-medium">Last Login {{ $user->last_login }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COMPANY DETAILS -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">Company Details</h5>
                    </div>

                    <div class="card-body p-4">
                        @if ($user->company)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Company Name</label>
                                    <div class="fw-medium">{{ $user->company->company_name }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-muted small">Company Email</label>
                                    <div class="fw-medium">{{ $user->company->email ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Mobile</label>
                                    <div class="fw-medium">{{ $user->company->mobile ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-muted small">City</label>
                                    <div class="fw-medium">{{ $user->company->city ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="text-muted small">Address</label>
                                    <div class="fw-medium">{{ $user->company->address ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">GST Number</label>
                                    <div class="fw-medium">{{ $user->company->gst_number ?? '-' }}</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-muted small">PAN Number</label>
                                    <div class="fw-medium">{{ $user->company->pan_number ?? '-' }}</div>
                                </div>
                            </div>

                            @if ($user->company->logo)
                                <div class="mt-3">
                                    <label class="text-muted small">Company Logo</label><br>
                                    <img src="{{ asset('storage/' . $user->company->logo) }}" alt="Logo" height="60">
                                </div>
                            @endif
                        @else
                            <div class="text-muted text-center">
                                No company details found.
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
