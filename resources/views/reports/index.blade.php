@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-primary">Financial & Performance Reports</h4>
        <div class="text-muted small">Showing data for: <span class="fw-semibold text-dark">{{ $startDate ?? 'All Time' }} to {{ $endDate ?? 'Today' }}</span></div>
    </div>

    {{-- ================= FILTERS ================= --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('reports.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Filter by User (Staff/Agent/Freelancer)</label>
                    <select name="user_id" class="form-select border-0 bg-light">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $userId == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->role }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Start Date</label>
                    <input type="date" name="start_date" class="form-control border-0 bg-light" value="{{ $startDate }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">End Date</label>
                    <input type="date" name="end_date" class="form-control border-0 bg-light" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Quick Filters</label>
                    <select name="quick_filter" class="form-select border-0 bg-light" onchange="this.form.submit()">
                        <option value="">Select Quick Range</option>
                        <option value="3m" {{ $quickFilter == '3m' ? 'selected' : '' }}>Last 3 Months</option>
                        <option value="6m" {{ $quickFilter == '6m' ? 'selected' : '' }}>Last 6 Months</option>
                        <option value="this_year" {{ $quickFilter == 'this_year' ? 'selected' : '' }}>This Year</option>
                        <option value="last_year" {{ $quickFilter == 'last_year' ? 'selected' : '' }}>Last Year</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= SUMMARY CARDS ================= --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small opacity-75">Total Revenue</span>
                        <i class="fas fa-coins opacity-50"></i>
                    </div>
                    <h2 class="mb-0 fw-bold">₹ {{ number_format($totalEarnings, 2) }}</h2>
                    <div class="small mt-2 opacity-75">Generated from calculations</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small opacity-75 fw-semibold">Pending Amount</span>
                        <i class="fas fa-hourglass-half opacity-50"></i>
                    </div>
                    <h2 class="mb-0 fw-bold">₹ {{ number_format($pendingAmount, 2) }}</h2>
                    <div class="small mt-2 opacity-75">Estimated to be collected</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted fw-semibold">Packages Created</span>
                        <i class="fas fa-box text-primary opacity-50"></i>
                    </div>
                    <h2 class="mb-0 fw-bold">{{ $packageCount }}</h2>
                    <div class="small mt-2 text-muted">Tour calculations performed</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted fw-semibold">Total Users</span>
                        <i class="fas fa-users text-success opacity-50"></i>
                    </div>
                    <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
                    <div class="small mt-2 text-muted">Across all roles</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= CHARTS ================= --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 fw-bold text-dark">
                    Revenue Trend Over Selected Period
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    
    // Process monthly revenue data
    const monthlyData = {!! json_encode($monthlyRevenue) !!};
    const labels = monthlyData.map(d => {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return months[d.month - 1] + ' ' + d.year;
    });
    const values = monthlyData.map(d => d.total);

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (₹)',
                data: values,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0d6efd',
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection
