@extends('frontend.layouts.app')

@section('content')
<div class="container mt-4">

    {{-- 🔷 Welcome Banner --}}
    <div class="card border-0 shadow-sm mb-4 bg-light">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="mb-1 fw-semibold">Welcome back, {{ $user->name }} 👋</h4>
                <p class="text-muted mb-0">
                    Last login: {{ $user->last_login }}
                </p>
            </div>

            <div class="d-flex gap-2">
                @if(auth()->check() && auth()->user()->role === 'Agent')
                    <a href="{{ route('agent.company.profile') }}" class="btn btn-outline-primary">
                        <i class="bi bi-building me-1"></i> Company Profile
                    </a>
                @endif

                @if(auth()->check() && auth()->user()->role === 'Staff')
                    <a href="{{ route('agent.target') }}" class="btn btn-primary">
                        <i class="bi bi-graph-up me-1"></i> My Target
                    </a>
                @endif

                <form action="{{ route('agent.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- 🔷 KPI CARDS --}}
    <div class="row g-4 mb-4">

        {{-- Total Quotations --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">Total Quotations</p>
                        <h3 class="fw-bold mb-0">{{ $counts['total_tour_calculations'] }}</h3>
                    </div>
                    <i class="bi bi-calculator fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Revenue / Volume --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        @if(auth()->user()->role == 'Staff')
                            <p class="mb-1 opacity-75">Total Volume</p>
                        @else
                            <p class="mb-1 opacity-75">Total Revenue</p>
                        @endif
                        <h3 class="fw-bold mb-0">₹ {{ number_format($counts['total_revenue']) }}</h3>
                    </div>
                    <i class="bi bi-currency-rupee fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Pending Bookings --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card bg-warning text-dark">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1">Pending Bookings</p>
                        <h3 class="fw-bold mb-0">{{ $counts['pending_bookings'] ?? 0 }}</h3>
                    </div>
                    <i class="bi bi-hourglass-split fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Monthly Revenue --}}
        @if(auth()->user()->role != 'Staff')
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card bg-dark text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">This Month</p>
                        <h3 class="fw-bold mb-0">₹ {{ number_format($counts['monthly_revenue'] ?? 0) }}</h3>
                    </div>
                    <i class="bi bi-graph-up-arrow fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- 🔷 Recent Quotations --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">Recent Quotations</h5>
            <a href="{{ route('calculation.report') }}" class="btn btn-sm btn-primary">
                View All
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Quotation No</th>
                        <th>Travel Date</th>
                        <th>Pax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($counts['recentCalculations'] as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $row->unique_no }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($row->travel_date)->format('d M Y') }}</td>
                            <td>{{ $row->total_pax }}</td>
                            <td class="fw-semibold">₹ {{ number_format($row->total_price) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No quotations found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
