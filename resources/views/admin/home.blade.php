@extends('admin.layout.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <i class="bi bi-speedometer2 text-primary"></i> Dashboard Overview
        </h4>
        <p class="text-muted mb-0">Selamat datang kembali! Berikut ringkasan bisnis Anda hari ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 g-lg-4 mb-4">
        <!-- Total Users -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small text-uppercase">Total Users</p>
                            <h3 class="fw-bold mb-0">{{ number_format($total_users) }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="bi bi-people-fill fs-4 text-primary"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-success small">
                        <i class="bi bi-arrow-up-circle-fill me-1"></i>
                        <span>Active customers</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small text-uppercase">Total Products</p>
                            <h3 class="fw-bold mb-0">{{ number_format($total_products) }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="bi bi-box-seam-fill fs-4 text-success"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-muted small">
                        <i class="bi bi-box me-1"></i>
                        <span>Items in catalog</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small text-uppercase">Total Orders</p>
                            <h3 class="fw-bold mb-0">{{ number_format($total_orders) }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="bi bi-receipt-cutoff fs-4 text-warning"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-muted small">
                        <i class="bi bi-cart-check me-1"></i>
                        <span>All time orders</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid Orders -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small text-uppercase">Paid Orders</p>
                            <h3 class="fw-bold mb-0">{{ number_format($paid_orders) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="bi bi-credit-card-fill fs-4 text-info"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-success small">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        <span>Successfully paid</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-3 g-lg-4">
        <!-- Sales Chart -->
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 fw-bold">
                                <i class="bi bi-graph-up text-primary"></i> Monthly Sales
                            </h5>
                            <p class="text-muted small mb-0">Grafik penjualan bulanan tahun ini</p>
                        </div>
                        <div class="badge bg-primary bg-opacity-10 text-primary">2024</div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-lightning-charge text-warning"></i> Quick Stats
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Conversion Rate -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Conversion Rate</span>
                            <span class="fw-bold text-success">
                                {{ $total_orders > 0 ? number_format(($paid_orders / $total_orders) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" 
                                 style="width: {{ $total_orders > 0 ? ($paid_orders / $total_orders) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <!-- Products per Category -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Avg Products/Category</span>
                            <span class="fw-bold">
                                {{ isset($total_categories) && $total_categories > 0 ? number_format($total_products / $total_categories, 1) : 0 }}
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 75%"></div>
                        </div>
                    </div>
                    <!-- Active Users -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Active Users Rate</span>
                            <span class="fw-bold text-info">85%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: 85%"></div>
                        </div>
                    </div>

                    <!-- Revenue Badge -->
                    <div class="alert alert-success border-0 mb-0" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-trophy-fill fs-3 me-3"></i>
                            <div>
                                <strong class="d-block">Great Performance!</strong>
                                <small>Bisnis Anda berkembang dengan baik</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-3 g-lg-4 mt-2">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-clock-history text-primary"></i> Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="bi bi-cart-check text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold">New order received</p>
                                    <small class="text-muted">Order #12345 has been placed</small>
                                </div>
                                <small class="text-muted">2 mins ago</small>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="bi bi-person-plus text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold">New user registered</p>
                                    <small class="text-muted">Welcome to new customer</small>
                                </div>
                                <small class="text-muted">15 mins ago</small>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="bi bi-box-seam text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold">Product stock updated</p>
                                    <small class="text-muted">Stock levels have been adjusted</small>
                                </div>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </div>
                    </div>
                </div>
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
                    label: 'Sales (Rp)',
                    data: [
                        1200000, 1500000, 1300000, 1800000,
                        2000000, 1700000, 2100000, 2500000,
                        2300000, 2600000, 3000000, 3500000
                    ],
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderColor: 'rgb(13, 110, 253)',
                    pointBackgroundColor: 'rgb(13, 110, 253)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return 'Sales: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000) + 'M';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    });
</script>
@endpush