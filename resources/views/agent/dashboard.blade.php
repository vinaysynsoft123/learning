@extends('frontend.layouts.app')

@section('content')

<!-- DASHBOARD HEADER -->
<div class="container">
      <div class="row g-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Welcome, {{ $user->name }}!</h3>
        <form action="{{ route('agent.logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger">Logout</button>
        </form>
    </div>
    <p class="text-muted">This is your dashboard.</p>
</div>

    <div class="row g-4">

        <!-- Total Packages Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Packages</h6>
                    <h3 class="fw-bold">125</h3>
                </div>
            </div>
        </div>

        <!-- Pending Bookings Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Pending Bookings</h6>
                    <h3 class="fw-bold">12</h3>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Revenue</h6>
                    <h3 class="fw-bold">24,500</h3>
                </div>
            </div>
        </div>

    </div>


</div>



@endsection
