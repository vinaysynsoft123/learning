@extends('frontend.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">My Performance Targets</h3>
        <div class="text-muted">Target period: {{ date('F Y') }}</div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Monthly Target -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Monthly Target</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Progress</span>
                        <span class="fw-bold">{{ $targetData['monthly']['percent'] }}%</span>
                    </div>
                    <div class="progress mb-3" style="height: 10px; border-radius: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $targetData['monthly']['percent'] }}%" aria-valuenow="{{ $targetData['monthly']['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">Achieved</small>
                            <span class="h5 fw-bold text-success">₹ {{ number_format($targetData['monthly']['achieved']) }}</span>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">Target</small>
                            <span class="h5 fw-bold">₹ {{ number_format($targetData['monthly']['target']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yearly Target -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Yearly Target</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Progress</span>
                        <span class="fw-bold">{{ $targetData['yearly']['percent'] }}%</span>
                    </div>
                    <div class="progress mb-3" style="height: 10px; border-radius: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $targetData['yearly']['percent'] }}%" aria-valuenow="{{ $targetData['yearly']['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">Achieved</small>
                            <span class="h5 fw-bold text-success">₹ {{ number_format($targetData['yearly']['achieved']) }}</span>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">Target</small>
                            <span class="h5 fw-bold">₹ {{ number_format($targetData['yearly']['target']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Comparison Graph -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">Month-on-Month Comparison</h5>
                </div>
                <div class="card-body">
                    <div style="height: 350px;">
                        <canvas id="comparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">Recent Activity Timeline</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush timeline-list" style="max-height: 400px; overflow-y: auto;">
                        @forelse($targetData['timeline'] as $activity)
                            <div class="list-group-item border-0 border-bottom px-4">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-bold text-primary">{{ $activity->unique_no }}</h6>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 small">Created quotation for <strong>{{ $activity->destination->name ?? 'N/A' }}</strong></p>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">{{ $activity->total_pax }} Pax</span>
                                    <span class="text-success fw-bold">₹ {{ number_format($activity->total_price) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center text-muted">
                                <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                                No recent activity logged.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('comparisonChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Last Month', 'Current Month'],
                datasets: [{
                    label: 'Revenue Achieved (₹)',
                    data: [{{ $targetData['comparison']['last'] }}, {{ $targetData['comparison']['current'] }}],
                    backgroundColor: [
                        'rgba(108, 117, 125, 0.6)',
                        'rgba(13, 110, 253, 0.6)'
                    ],
                    borderColor: [
                        'rgb(108, 117, 125)',
                        'rgb(13, 110, 253)'
                    ],
                    borderWidth: 2,
                    borderRadius: 5,
                    barThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000) {
                                    return '₹' + (value / 1000) + 'k';
                                }
                                return '₹' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>

<style>
.timeline-list::-webkit-scrollbar {
    width: 6px;
}
.timeline-list::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.timeline-list::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}
.timeline-list::-webkit-scrollbar-thumb:hover {
    background: #99;
}
</style>
@endsection
