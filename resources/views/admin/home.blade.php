@extends('admin.layout.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4">

    {{-- TOTAL USERS --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Users</h6>
                    <h3 class="fw-bold mb-0">{{ $total_users }}</h3>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                    <i class="bi bi-people fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL PRODUCTS --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Products</h6>
                    <h3 class="fw-bold mb-0">{{ $total_products }}</h3>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-3">
                    <i class="bi bi-box-seam fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL ORDERS --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Orders</h6>
                    <h3 class="fw-bold mb-0">{{ $total_orders }}</h3>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3">
                    <i class="bi bi-receipt fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- PAID ORDERS --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Paid Orders</h6>
                    <h3 class="fw-bold mb-0">{{ $paid_orders }}</h3>
                </div>
                <div class="bg-info bg-opacity-10 text-info rounded-circle p-3">
                    <i class="bi bi-credit-card fs-4"></i>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- GRAFIK --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Monthly Sales</h5>
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    data: [
                        1200000, 1500000, 1300000, 1800000,
                        2000000, 1700000, 2100000, 2500000,
                        2300000, 2600000, 3000000, 3500000
                    ],
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(13,110,253,0.15)',
                    borderColor: '#0d6efd',
                    pointRadius: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    });
</script>
@endpush