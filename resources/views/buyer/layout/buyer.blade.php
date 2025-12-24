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
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />



<body class="bg-light">

    {{-- NAVBAR --}}
    @include('buyer.layout.nav')

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
                            <a href="/" class="text-white-50 text-decoration-none">
                                <i class="bi bi-chevron-right"></i> Home
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none">
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