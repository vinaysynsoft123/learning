@extends('frontend.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">My Activity & Reports</h3>
            <a href="{{ route('package.calculator') }}" class="btn btn-primary shadow-sm px-4">
                <i class="bi bi-plus-lg me-1"></i> New Quotation
            </a>
        </div>

        {{-- 🔍 Search Filters --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="{{ route('calculation.report') }}" method="GET" class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">From Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">To Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-filter me-1"></i> Filter Results
                        </button>
                        @if($startDate || $endDate)
                            <a href="{{ route('calculation.report') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- 📊 Stats Overview --}}
        <div class="row g-4 mb-5">
            @php
                $timeframes = [
                    'current_month' => 'Current Month',
                    'last_6_months' => 'Last 6 Months',
                    'this_year' => 'This Year (' . date('Y') . ')',
                    'last_year' => 'Last Year (' . (date('Y') - 1) . ')',
                ];
                $colors = ['primary', 'info', 'success', 'dark'];
                $i = 0;
            @endphp

            @foreach ($timeframes as $key => $label)
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-header bg-{{ $colors[$i++] }} text-white py-2">
                            <small class="fw-bold uppercase">{{ $label }}</small>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-2 text-muted small">Total Quotations</div>
                            <h4 class="fw-bold mb-3">{{ number_format($stats[$key]['count']) }}</h4>
                            
                            <hr class="my-2 opacity-50">
                            
                            <div class="text-muted small">Total Revenue</div>
                            <h5 class="fw-bold text-success mb-0">₹ {{ number_format($stats[$key]['revenue']) }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h5 class="fw-bold mb-3">All Quotation Logs</h5>
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Quotation No</th>
                            <th>Destination</th>
                            <th>Package</th>
                            <th>Travel Date</th>
                            <th>Pax</th>
                            <th>Total Amount</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $row)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $row->unique_no }}
                                    </span>
                                </td>
                                <td>{{ $row->destination->name ?? '-' }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $row->package->name ?? '-' }}</div>
                                    <small class="text-muted">{{ $row->theme->name ?? '' }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($row->travel_date)->format('d M Y') }}</td>
                                <td>{{ $row->total_pax }}</td>
                                <td class="fw-bold text-success">₹ {{ number_format($row->total_price) }}</td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('calculation.show', $row->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No quotations found yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
