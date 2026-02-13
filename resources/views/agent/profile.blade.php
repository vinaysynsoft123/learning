@extends('frontend.layouts.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">My Profile</h3>
            <p class="text-muted mb-0">View your personal & company details</p>
        </div>
        <a href="#" class="btn btn-primary">
            ✏️ Edit Profile
        </a>
    </div>

    <div class="row g-4">

        <!-- LEFT : BASIC INFO -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-4">

                    <div class="mb-3">
                        <div class="rounded-circle bg-primary text-white d-inline-flex
                                    align-items-center justify-content-center"
                             style="width:90px;height:90px;font-size:32px;">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    </div>

                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>

                    <span class="badge bg-success px-3 py-2">
                        {{ $user->role }}
                    </span>

                    <hr class="my-4">

                    <div class="text-start">
                        <p class="mb-1 text-muted">📞 Mobile</p>
                        <p class="fw-semibold">{{ $user->mobile ?? 'Not Provided' }}</p>

                        <p class="mb-1 text-muted">🕒 Last Login</p>
                        <p class="fw-semibold">
                            {{ $user->last_login ?? '—' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT : COMPANY / BUSINESS INFO -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                 <h5 class="fw-bold mb-3">🏢 Company Details</h5>

<div class="row g-3">
    <div class="col-md-6">
        <label class="text-muted">Company Name</label>
        <div class="fw-semibold">
            {{ $company->company_name ?? 'Not Added' }}
        </div>
    </div>

    <div class="col-md-6">
        <label class="text-muted">Business Type</label>
        <div class="fw-semibold">
            {{ $company->business_type ?? 'Travel Agency' }}
        </div>
    </div>

    <div class="col-md-6">
        <label class="text-muted">GST Number</label>
        <div class="fw-semibold">
            {{ $company->gst_number ?? 'Not Available' }}
        </div>
    </div>

    <div class="col-md-6">
        <label class="text-muted">PAN Number</label>
        <div class="fw-semibold">
            {{ $company->pan_number  ?? '—' }}
        </div>
    </div>

    <div class="col-md-12">
        <label class="text-muted">Office Address</label>
        <div class="fw-semibold">
            {{ $company->address ?? 'Address not provided' }}
        </div>
    </div>
</div>

<hr class="my-4">

<h5 class="fw-bold mb-3">🏦 Bank Details</h5>

<div class="row g-3">
    <div class="col-md-4">
        <label class="text-muted">Bank Name</label>
        <div class="fw-semibold">
            {{ $company->bank_name ?? '—' }}
        </div>
    </div>

    <div class="col-md-4">
        <label class="text-muted">Account No</label>
        <div class="fw-semibold">
            {{ $company->account_no ?? '—' }}
        </div>
    </div>

    <div class="col-md-4">
        <label class="text-muted">IFSC Code</label>
        <div class="fw-semibold">
            {{ $company->ifsc_code ?? '—' }}
        </div>
    </div>
</div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
