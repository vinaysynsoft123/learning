@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">System Settings</h3>
            <p class="text-muted mb-0">Manage your application's global configuration and branding.</p>
        </div>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        
        <div class="row g-4">
            {{-- General Configuration --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-gear-fill me-2 text-primary"></i>General Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 text-dark font-weight-bold">
                                <label class="form-label fw-semibold small text-uppercase">Application Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-info-circle"></i></span>
                                    <input type="text" name="name" class="form-control border-0 bg-light" value="{{ $settings->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">Support Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-0 bg-light" value="{{ $settings->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">Contact Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" name="mobile" class="form-control border-0 bg-light" value="{{ $settings->mobile }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase">City / Location</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="city" class="form-control border-0 bg-light" value="{{ $settings->city }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small text-uppercase">Business Address</label>
                                <textarea name="address" class="form-control border-0 bg-light" rows="4" required>{{ $settings->address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                        <i class="bi bi-check2-circle me-2"></i>Save Configuration
                    </button>
                </div>
            </div>

            {{-- Branding & Logo --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-image me-2 text-primary"></i>Branding</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-uppercase d-block mb-3">Company Logo</label>
                            <div class="logo-preview-container bg-light rounded-4 p-4 mb-3 d-flex align-items-center justify-content-center" style="min-height: 200px; border: 2px dashed #dee2e6;">
                                <img id="logoPreview" 
                                     src="{{ $settings->logo ? asset('storage/' . $settings->logo) : 'https://via.placeholder.com/300x150?text=Your+Logo' }}" 
                                     class="img-fluid" 
                                     style="max-height: 120px; object-fit: contain;">
                            </div>
                            
                            <div class="mt-3">
                                <input type="file" name="logo" id="logoInput" class="d-none" accept="image/*" onchange="previewLogo(event)">
                                <button type="button" class="btn btn-outline-primary btn-sm px-4" onclick="document.getElementById('logoInput').click()">
                                    <i class="bi bi-upload me-2"></i>Upload New Logo
                                </button>
                                <p class="text-muted small mt-3">
                                    <i class="bi bi-info-circle me-1"></i> Use PNG or SVG with transparent background for best results (Max 2MB).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .bg-light { background-color: #f8f9fa !important; }
    .card { border-radius: 12px; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .input-group-text { color: #6c757d; }
    .logo-preview-container { transition: all 0.3s ease; }
    .logo-preview-container:hover { border-color: #0d6efd !important; }
</style>

<script>
function previewLogo(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('logoPreview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
