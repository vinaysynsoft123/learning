@extends('layouts.app')

@section('content')
<h4 class="mb-4 fw-bold">Master Data Reports ({{ $year }})</h4>

{{-- ================= SUMMARY CARDS ================= --}}
<div class="row g-4 mb-4">
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <small>Users</small>
                <h3>{{ $totalUsers }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <small>Hotel Categories</small>
                <h3>{{ $totalHotelCategories }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <small>Vehicles</small>
                <h3>{{ $totalVehicles }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <small>Themes</small>
                <h3>{{ $totalThemes }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <small>Packages</small>
                <h3>{{ $totalPackages }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <small>Destinations</small>
                <h3>{{ $totalDestinations }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- ================= CHARTS ================= --}}
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">Users Registered Per Month</div>
            <div class="card-body">
                <canvas id="usersChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">Hotel Categories Added Per Month</div>
            <div class="card-body">
                <canvas id="hotelChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">Vehicles Added Per Month</div>
            <div class="card-body">
                <canvas id="vehicleChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const labels = {!! json_encode(range(1,12)) !!}.map(m => new Date(0, m-1).toLocaleString('default', { month: 'short' }));

    const usersData = {!! json_encode(array_replace(array_fill(1,12,0), $monthlyUsers->toArray())) !!};
    const hotelData = {!! json_encode(array_replace(array_fill(1,12,0), $monthlyHotelCategories->toArray())) !!};
    const vehicleData = {!! json_encode(array_replace(array_fill(1,12,0), $monthlyVehicles->toArray())) !!};

    new Chart(document.getElementById('usersChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{ label: 'Users', data: usersData, backgroundColor: '#0d6efd' }]
        }
    });

    new Chart(document.getElementById('hotelChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{ label: 'Hotel Categories', data: hotelData, borderColor: '#198754', backgroundColor: 'rgba(25,135,84,0.2)', fill: true }]
        }
    });

    new Chart(document.getElementById('vehicleChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{ label: 'Vehicles', data: vehicleData, backgroundColor: '#ffc107' }]
        }
    });

});
</script>
@endsection
