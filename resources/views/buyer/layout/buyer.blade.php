<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Buyer') - MyShop</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
        /* Top Bar Styles */
        .top {
            background: whitesmoke;
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
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        /* Navbar Container Wrapper */
        .navbar-wrapper {
            background-color: #f8f9fa;
            padding: 10px 0 0 0; /* Hilangkan padding bottom */
            margin-bottom: 0; /* Hilangkan margin bottom */
        }

        /* Navbar Styles */
        .navbar-custom {
            background-color: #393a3bff;
            border-radius: 5px;
            padding: 12px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        /* Main Content - Kurangi margin top */
        main {
            min-height: calc(100vh - 400px);
        }

        main.container {
            margin-top: 2rem !important; /* Kurangi dari 3rem (my-5) menjadi 2rem */
        }

        /* Khusus untuk halaman dashboard - hilangkan margin top */
        .dashboard-content {
            margin-top: 1rem !important;
        }

        /* Footer Hover Effects */
        footer a.text-white-50:hover {
            color: #fff !important;
            transition: color 0.3s ease;
        }

        footer .btn-outline-light:hover {
            background: white;
            color: #212529;
            transform: scale(1.1);
            transition: all 0.3s ease;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .dropdown-toggle {
            color: white !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .top-info-list {
                flex-direction: column;
                gap: 10px;
            }

            .top {
                text-align: center;
            }

            .navbar-wrapper {
                padding: 10px 0 0 0;
            }

            .navbar-custom {
                border-radius: 0;
            }

            main.container {
                margin-top: 1.5rem !important;
            }
        }
    </style>
</head>

<body class="bg-light">

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

    {{-- NAVBAR WRAPPER --}}
    <div class="navbar-wrapper">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-custom">
                {{-- Brand --}}
                <a class="navbar-brand fw-bold" href="{{ route('buyer.dashboard') }}">
                    <i class="bi bi-shop"></i> MyShop
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
                                href="{{ route('buyer.dashboard') }}">
                                <i class="bi bi-house-door"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('buyer.products.*') ? 'active' : '' }}"
                                href="{{ route('buyer.products.index') }}">
                                <i class="bi bi-grid"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }}"
                                href="{{ route('buyer.cart.index') }}">
                                <i class="bi bi-cart3"></i> Cart
                            </a>
                        </li>
                    </ul>

                    {{-- Right Menu --}}
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <i class="bi bi-person"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <i class="bi bi-bag"></i> My Orders
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="container {{ request()->routeIs('buyer.dashboard') ? 'dashboard-content' : 'my-4' }}">
        @if(!request()->routeIs('buyer.dashboard'))
            <h4 class="mb-4 fw-bold">@yield('page-title')</h4>
        @endif
        
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-dark text-white mt-5">
        <div class="container py-5">
            <div class="row g-4">
                {{-- Brand Section --}}
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-shop"></i> MyShop
                    </h5>
                    <p class="text-white-50 mb-3">
                        Your trusted online shopping destination for quality products at the best prices.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" 
                           style="width: 38px; height: 38px; padding: 0; display: flex; align-items: center; justify-content: center;"
                           title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" 
                           style="width: 38px; height: 38px; padding: 0; display: flex; align-items: center; justify-content: center;"
                           title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" 
                           style="width: 38px; height: 38px; padding: 0; display: flex; align-items: center; justify-content: center;"
                           title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" 
                           style="width: 38px; height: 38px; padding: 0; display: flex; align-items: center; justify-content: center;"
                           title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('buyer.dashboard') }}" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Home
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('buyer.products.index') }}" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Shop
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> About Us
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Contact
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Customer Service --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Customer Service</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Help Center
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Track Order
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Returns
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Shipping Info
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Contact Us</h6>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            123 Shop Street, City
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill me-2"></i>
                            info@myshop.com
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone-fill me-2"></i>
                            +1 234 567 890
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Divider --}}
            <hr class="my-4 border-secondary">

            {{-- Bottom Bar --}}
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <small class="text-white-50">
                        &copy; {{ date('Y') }} MyShop. All rights reserved.
                    </small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small class="text-white-50">
                        <a href="#" class="text-white-50 text-decoration-none me-3">Privacy Policy</a>
                        <a href="#" class="text-white-50 text-decoration-none me-3">Terms of Service</a>
                        <a href="#" class="text-white-50 text-decoration-none">Cookie Policy</a>
                    </small>
                </div>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>