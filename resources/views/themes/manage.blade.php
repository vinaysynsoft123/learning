@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">{{ isset($theme) ? 'Edit Theme' : 'Add New Theme' }}</h3>
            <p class="text-muted mb-0">Define a new category to group your travel packages and itineraries.</p>
        </div>
        <a href="{{ route('themes.index') }}" class="btn btn-outline-primary shadow-sm rounded-3">
            <i class="bi bi-arrow-left me-2"></i>Back to Themes
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-tag me-2 text-primary"></i>Theme Configuration</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ isset($theme) ? route('themes.update', $theme) : route('themes.store') }}">
                        @csrf
                        @if(isset($theme))
                            @method('PUT')
                        @endif

                        <input type="hidden" name="destination_id" value="1">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-uppercase">Theme Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-palette"></i></span>
                                <input type="text" name="name" class="form-control border-0 bg-light px-3" 
                                       value="{{ old('name', $theme->name ?? '') }}" placeholder="e.g. Honeymoon Special" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-uppercase">Theme Status</label>
                            <div class="d-flex gap-4 p-3 bg-light rounded-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_active" value="1" @checked(old('status', $theme->status ?? 1) == 1)>
                                    <label class="form-check-label text-success fw-bold" for="status_active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0" @checked(old('status', $theme->status ?? 1) == 0)>
                                    <label class="form-check-label text-danger fw-bold" for="status_inactive">Inactive</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-10">
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 shadow-sm rounded-3 fw-bold">
                                <i class="bi bi-check2-circle me-2"></i>{{ isset($theme) ? 'Update Theme' : 'Create Theme' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: none !important;
    }
    .input-group-text { color: #6c757d; }
    .card { border-radius: 12px; }
</style>
@endsection
