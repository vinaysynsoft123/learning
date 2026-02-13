@extends('frontend.layouts.app')

@section('content')
<div class="container py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Company Profile</h3>
            <p class="text-muted mb-0">Update your company & business information</p>
        </div>
        <a href="{{ route('agent.profile') }}" class="btn btn-outline-secondary">
            ← Back to Profile
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        <!-- LEFT : LOGO / INFO -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-4">

                    <div class="mb-3">
                        @if(!empty($user->company->logo))
                            <img src="{{ asset('storage/'.$user->company->logo) }}"
                                 class="rounded-circle border"
                                 style="width:100px;height:100px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex
                                        align-items-center justify-content-center"
                                 style="width:100px;height:100px;font-size:36px; margin-left:105px">
                                {{ strtoupper(substr($user->company->company_name ?? $user->name,0,1)) }}
                            </div>
                        @endif
                    </div>

                    <h5 class="fw-bold mb-1">
                        {{ $user->company->company_name ?? 'Company Name' }}
                    </h5>
                    <p class="text-muted mb-2">{{ $user->company->email ?? $user->email }}</p>

                    <hr>

                    <div class="text-start">
                        <p class="mb-1 text-muted">📞 Mobile</p>
                        <p class="fw-semibold">{{ $user->company->mobile ?? '—' }}</p>

                        <p class="mb-1 text-muted">📍 Location</p>
                        <p class="fw-semibold">
                            {{ $user->company->city ?? '' }}
                            {{ $user->company->state ? ', '.$user->company->state : '' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT : FORM -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form action="{{ route('agent.company.profile.update') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <!-- Company Info -->
                        <h5 class="fw-bold mb-3">🏢 Company Information</h5>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label text-muted">Company Name</label>
                                <input type="text" name="company_name" class="form-control"
                                       value="{{ old('company_name', $user->company->company_name ?? '') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $user->company->email ?? '') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted">Mobile</label>
                                <input type="text" name="mobile" class="form-control"
                                       value="{{ old('mobile', $user->company->mobile ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted">Address</label>
                                <input type="text" name="address" class="form-control"
                                       value="{{ old('address', $user->company->address ?? '') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted">City</label>
                                <input type="text" name="city" class="form-control"
                                       value="{{ old('city', $user->company->city ?? '') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted">State</label>
                                <input type="text" name="state" class="form-control"
                                       value="{{ old('state', $user->company->state ?? '') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted">Pincode</label>
                                <input type="text" name="pincode" class="form-control"
                                       value="{{ old('pincode', $user->company->pincode ?? '') }}">
                            </div>

                        </div>

                        <hr class="my-4">

                        <!-- Legal -->
                        <h5 class="fw-bold mb-3">📄 Legal Details</h5>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label text-muted">GST Number</label>
                                <input type="text" name="gst_number" class="form-control"
                                       value="{{ old('gst_number', $user->company->gst_number ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted">PAN Number</label>
                                <input type="text" name="pan_number" class="form-control"
                                       value="{{ old('pan_number', $user->company->pan_number ?? '') }}">
                            </div>

                        </div>

                        <hr class="my-4">

                        <!-- Logo -->
                        <h5 class="fw-bold mb-3">🖼️ Company Logo</h5>
                        <input type="file" name="logo" class="form-control">

                        <!-- Submit -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                💾 Save Changes
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
