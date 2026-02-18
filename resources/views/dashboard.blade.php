@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Command Center</h3>
            <p class="text-muted mb-0">Hello, {{ auth()->user()->name }}. Here's what's happening today.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white border shadow-sm btn-sm">
                <i class="bi bi-download me-1"></i> Export Data
            </button>
            <div class="dropdown">
                <button class="btn btn-primary shadow-sm btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-plus-lg me-1"></i> Quick Create
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="{{ route('packages.create') }}">New Package</a></li>
                    <li><a class="dropdown-item" href="{{ route('users.create') }}">New User</a></li>
                    <li><a class="dropdown-item" href="{{ route('destinations.create') }}">New Destination</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Top Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-primary-soft p-3 rounded-3">
                            <i class="bi bi-currency-rupee text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0 small uppercase fw-bold">Total Revenue</h6>
                            <h3 class="mb-0 fw-bold">₹{{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-success-soft p-3 rounded-3">
                            <i class="bi bi-calculator text-success fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0 small uppercase fw-bold">Calculations</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($counts['calculations']) }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-warning-soft p-3 rounded-3">
                            <i class="bi bi-people text-warning fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0 small uppercase fw-bold">Active Users</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($counts['users']) }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-danger-soft p-3 rounded-3">
                            <i class="bi bi-box-seam text-danger fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-0 small uppercase fw-bold">Packages</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($counts['packages']) }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-danger" style="width: 80%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Analytics --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Revenue Overview</h5>
                    <select class="form-select form-select-sm border-0 bg-light shadow-none" style="width: 120px;">
                        <option>This Year</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="mainRevenueChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0 fw-bold">User Distribution</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div style="height: 250px;">
                        <canvas id="userDistChart"></canvas>
                    </div>
                    <div class="mt-4">
                        @foreach($userBreakdown as $role => $count)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small"><i class="bi bi-circle-fill me-2" style="color: {{ $loop->index == 0 ? '#0d6efd' : ($loop->index == 1 ? '#198754' : '#ffc107') }}"></i> {{ $role }}</span>
                                <span class="fw-bold small">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity Tables --}}
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Calculations</h5>
                    <a href="{{ route('admin.package.calculations') }}" class="btn btn-link btn-sm text-decoration-none p-0">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 small text-uppercase py-3 ps-4">Quotation No</th>
                                <th class="border-0 small text-uppercase py-3">Agent</th>
                                <th class="border-0 small text-uppercase py-3">Package</th>
                                <th class="border-0 small text-uppercase py-3 pe-4 text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCalculations as $calc)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold">{{ $calc->unique_no }}</span>
                                        <div class="small text-muted">{{ $calc->created_at->format('d M, h:i A') }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <span class="small fw-bold text-primary">{{ substr($calc->agent->name ?? 'G', 0, 1) }}</span>
                                            </div>
                                            <span class="small">{{ $calc->agent->name ?? 'Guest' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="small text-truncate d-inline-block" style="max-width: 150px;">{{ $calc->package->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="pe-4 text-end fw-bold text-primary">
                                        ₹{{ number_format($calc->total_price, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted">No recent calculations</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">New Registrations</h5>
                    <a href="{{ route('users') }}" class="btn btn-link btn-sm text-decoration-none p-0">View All</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentUsers as $user)
                            <li class="list-group-item border-0 py-3 px-4 d-flex align-items-center">
                                <div class="avatar rounded-circle bg-light p-2 me-3">
                                    <i class="bi bi-person text-dark fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                    <div class="small text-muted">{{ $user->email }} • <span class="badge {{ $user->role == 'Admin' ? 'bg-danger' : ($user->role == 'Agent' ? 'bg-primary' : 'bg-info') }} bg-opacity-10 text-{{ $user->role == 'Admin' ? 'danger' : ($user->role == 'Agent' ? 'primary' : 'info') }} py-0 px-2">{{ $user->role }}</span></div>
                                </div>
                                <div class="ms-auto">
                                    <span class="small text-muted">{{ $user->created_at->diffForHumans(null, true) }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item border-0 py-4 text-center text-muted">No new users</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
    
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .avatar-sm { font-size: 0.8rem; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Main Revenue Chart
    const revCtx = document.getElementById('mainRevenueChart').getContext('2d');
    const revenueData = {!! json_encode($revenueMonthly) !!};
    
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const labels = revenueData.map(d => months[d.month - 1]);
    const values = revenueData.map(d => d.total);

    new Chart(revCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue',
                data: values,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.05)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false }, beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });

    // User Distribution Chart
    const distCtx = document.getElementById('userDistChart').getContext('2d');
    const userBreakdown = {!! json_encode($userBreakdown) !!};
    
    new Chart(distCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(userBreakdown),
            datasets: [{
                data: Object.values(userBreakdown),
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endsection
