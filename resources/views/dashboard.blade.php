@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Dashboard</h4>
        <p class="text-muted mb-0">
            Welcome back, {{ auth()->user()->name }} 👋
        </p>
    </div>
    <span class="badge bg-light text-dark">
        {{ now()->format('d M Y') }}
    </span>
</div>

<div class="row g-4 mb-4">

    {{-- Destinations --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $counts['destinations'] }}</h4>
                    <p class="text-muted mb-1">Destinations</p>
                </div>
                <div class="text-primary fs-3">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Themes --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $counts['themes'] }}</h4>
                    <p class="text-muted mb-1">Themes</p>
                </div>
                <div class="text-success fs-3">
                    <i class="bi bi-palette-fill"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Hotel Categories --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $counts['hotelCategories'] }}</h4>
                    <p class="text-muted mb-1">Hotel Categories</p>
                </div>
                <div class="text-warning fs-3">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Vehicles --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $counts['vehicles'] }}</h4>
                    <p class="text-muted mb-1">Vehicles</p>
                </div>
                <div class="text-info fs-3">
                    <i class="bi bi-truck-front-fill"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Packages --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $counts['packages'] }}</h4>
                    <p class="text-muted mb-1">Packages</p>
                </div>
                <div class="text-danger fs-3">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Users --}}
    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h4 class="mb-0">{{ $counts['users'] }}</h4>
                    <p class="text-muted mb-1">Users</p>
                </div>
                <div class="text-dark fs-3">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
