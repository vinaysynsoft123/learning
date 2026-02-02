@extends('frontend.layouts.app')

@section('content')
    <!-- DASHBOARD HEADER -->
    <div class="container mt-4">
        <div class="row g-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Welcome, {{ $user->name }}!</h3>
                <form action="{{ route('agent.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger">Logout</button>
                </form>
            </div>
             <p class="text-muted">Last Login {{ $user->last_login }}</p>
            <p class="text-muted">This is your dashboard.</p>
        </div>

        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Total Quotations</h6>
                                <h3 class="fw-bold">{{ $counts['total_tour_calculations'] }}</h3>
                            </div>
                            <i class="bi bi-calculator fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Total Revenue</h6>
                                <h3 class="fw-bold">₹ {{ number_format($counts['total_revenue']) }}</h3>
                            </div>
                            <i class="bi bi-currency-rupee fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Pending Bookings</h6>
                                <h3 class="fw-bold">{{ $counts['pending_bookings'] ?? 0 }}</h3>
                            </div>
                            <i class="bi bi-hourglass-split fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-dark text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>This Month</h6>
                                <h3 class="fw-bold">₹ {{ number_format($counts['monthly_revenue'] ?? 0) }}</h3>
                            </div>
                            <i class="bi bi-graph-up-arrow fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h5 class="mb-0">Recent Quotations</h5>
                    <a href="{{ route('calculation.report') }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
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
                            @foreach ($counts['recentCalculations'] as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->unique_no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->travel_date)->format('d M Y') }}</td>
                                    <td>{{ $row->total_pax }}</td>
                                    <td>₹ {{ number_format($row->total_price) }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
