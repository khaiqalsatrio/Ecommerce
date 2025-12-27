<style>
    /* Top Bar Styles */
    .top {
        background: #ecececff;
        color: dark;
        padding: 10px 0;
        font-size: 0.875rem;
    }

    .top-info-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .top-info-list li {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .top-info-list li i {
        font-size: 1rem;
    }

    .top-info-list li.success {
        background: rgba(255, 255, 255, 0.2);
        padding: 5px 15px;
        border-radius: 20px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.8;
        }
    }

    /* Navbar Container Wrapper */
    .navbar-wrapper {
        background-color: #f8f9fa;
        padding: 0px;
        /* HILANGKAN SEMUA PADDING */
        margin: 0;
    }

    /* Navbar Styles */
    .navbar-custom {
        background-color: #212529;
        border-radius: 5px;
        /* bikin navbar tidak full nempel */
        padding: 10px 20px;
        /*ini OK, bukan masalah */
    }

    .navbar-brand {
        font-size: 1.5rem;
        letter-spacing: 1px;
        color: white !important;
    }

    .nav-link {
        transition: all 0.3s ease;
        position: relative;
        color: rgba(255, 255, 255, 0.85) !important;
        padding: 8px 16px !important;
    }

    .nav-link:hover {
        color: #667eea !important;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 6px;
    }

    .nav-link.active {
        color: white !important;
        background-color: #646568ff;
        border-radius: 6px;
        font-weight: 500;
    }
</style>

{{-- TOP BAR --}}
<div class="top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-info-list">
                    <li>
                        <i class="bi bi-calendar-date"></i>
                        <span>{{ date('F d, Y') }}</span>
                    </li>
                    <li class="success">
                        <i class="bi bi-broadcast-pin"></i>
                        <span>Store is now open! Enjoy exclusive deals and offers.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- NAVBAR --}}
<div class="navbar-wrapper">
    <div class="container mt-3">
        <nav class="navbar navbar-expand-lg navbar-custom">

            {{-- Brand --}}
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-shop"></i> MyCoffee
            </a>

            {{-- Toggler --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#buyerNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menu --}}
            <div class="collapse navbar-collapse" id="buyerNav">

                {{-- Left Menu --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}"
                            href="/">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('buyer.products.*') ? 'active' : '' }}"
                            href="{{ route('buyer.products.index') }}">
                            <i class="bi bi-grid"></i> Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }}"
                            href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3"></i> Cart
                        </a>
                    </li>
                </ul>

                {{-- Right Menu --}}
                <ul class="navbar-nav">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('buyer.profile') }}">
                                    <i class="bi bi-person"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    <i class="bi bi-bag"></i> My Orders
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="button" class="dropdown-item text-danger" onclick="confirmLogout()">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary px-3" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                    @endauth
                </ul>

            </div>
        </nav>
    </div>
</div>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Sign out?',
            html: '<span class="text-light-50">You will be logged out from your account.</span>',
            icon: 'warning',

            background: '#1e1e2f',
            color: '#f8f9fa',

            showCancelButton: true,
            focusCancel: true,
            reverseButtons: true,
            buttonsStyling: false,

            confirmButtonText: 'Yes, Sign Out',
            cancelButtonText: 'Cancel',

            customClass: {
                popup: 'rounded-4 shadow-lg',
                title: 'fw-semibold',
                confirmButton: 'btn btn-danger px-4 py-2 rounded-3 me-2',
                cancelButton: 'btn btn-outline-light px-4 py-2 rounded-3'
            },

            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Signing out...',
                    text: 'Please wait a moment',
                    icon: 'success',

                    background: '#1e1e2f',
                    color: '#f8f9fa',

                    timer: 1200,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    document.getElementById('logout-form').submit();
                }, 900);
            }
        });
    }
</script>