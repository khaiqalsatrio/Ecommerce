@extends('buyer.layout.buyer')

@section('title', 'Home')

@section('content')

{{-- HERO BANNER --}}
<div class="mb-5 ">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner rounded-3 shadow">
            {{-- Slide 1 --}}
            <div class="carousel-item active">
                <div class="position-relative" style="height: 400px; background: linear-gradient(135deg, #212529 0%, #212529 100%);">
                    <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-100 px-3">
                        <h1 class="display-4 fw-bold mb-3">Selamat Datang di MyShop</h1>
                        <p class="lead mb-4">Temukan produk berkualitas dengan harga terbaik</p>
                        <a href="#products" class="btn btn-light btn-lg px-4 rounded-pill">
                            <i class="bi bi-bag-check me-2"></i>Belanja Sekarang
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="carousel-item">
                <div class="position-relative" style="height: 400px; background: linear-gradient(135deg, #212529 0%, #212529 100%);">
                    <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-100 px-3">
                        <h1 class="display-4 fw-bold mb-3">Promo Spesial</h1>
                        <p class="lead mb-4">Diskon hingga 50% untuk produk pilihan</p>
                        <a href="#products" class="btn btn-light btn-lg px-4 rounded-pill">
                            <i class="bi bi-tags me-2"></i>Lihat Promo
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 3 --}}
            <div class="carousel-item">
                <div class="position-relative" style="height: 400px; background: linear-gradient(135deg, #212529 0%, #212529 100%);">
                    <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-100 px-3">
                        <h1 class="display-4 fw-bold mb-3">Gratis Ongkir</h1>
                        <p class="lead mb-4">Untuk pembelian minimal Rp 100.000</p>
                        <a href="#products" class="btn btn-light btn-lg px-4 rounded-pill">
                            <i class="bi bi-truck me-2"></i>Belanja Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

{{-- FEATURES SECTION --}}
<div class="row g-3 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center py-4">
            <div class="card-body">
                <i class="bi bi-truck fs-1 text-primary mb-3"></i>
                <h5 class="fw-bold">Gratis Ongkir</h5>
                <p class="text-muted small mb-0">Pembelian minimal Rp 100.000</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center py-4">
            <div class="card-body">
                <i class="bi bi-shield-check fs-1 text-success mb-3"></i>
                <h5 class="fw-bold">Pembayaran Aman</h5>
                <p class="text-muted small mb-0">Transaksi terjamin 100% aman</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center py-4">
            <div class="card-body">
                <i class="bi bi-headset fs-1 text-info mb-3"></i>
                <h5 class="fw-bold">Layanan 24/7</h5>
                <p class="text-muted small mb-0">Customer service siap membantu</p>
            </div>
        </div>
    </div>
</div>

{{-- PRODUCTS SECTION --}}
<div id="products">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-box-seam me-2"></i>Produk Terbaru
        </h4>
        <a href="#" class="btn btn-outline-primary btn-sm">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-lift">

                <!-- IMAGE CAROUSEL -->
                <div id="carouselProduct{{ $product->id }}"
                    class="carousel slide"
                    data-bs-ride="carousel">

                    <div class="carousel-inner ratio ratio-4x3">

                        @if($product->images->count())
                        @foreach($product->images as $key => $img)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img
                                src="{{ asset('storage/'.$img->image) }}"
                                class="d-block w-100 object-fit-cover"
                                alt="{{ $product->name }}">
                        </div>
                        @endforeach
                        @else
                        <div class="carousel-item active">
                            <img
                                src="https://via.placeholder.com/400x300?text=No+Image"
                                class="d-block w-100 object-fit-cover"
                                alt="No Image">
                        </div>
                        @endif

                    </div>

                    {{-- CONTROL (hanya tampil kalau >1 gambar) --}}
                    @if($product->images->count() > 1)
                    <button class="carousel-control-prev"
                        type="button"
                        data-bs-target="#carouselProduct{{ $product->id }}"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next"
                        type="button"
                        data-bs-target="#carouselProduct{{ $product->id }}"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    @endif
                </div>

                <!-- BODY -->
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold mb-1 text-truncate">
                        {{ $product->name }}
                    </h6>

                    <span class="fw-bold text-success fs-6 mb-3">
                        Rp {{ number_format($product->price,0,',','.') }}
                    </span>

                    <a href="{{ route('products.show', $product->id) }}"
                        class="btn btn-outline-primary btn-sm mt-auto w-100">
                        <i class="bi bi-eye me-1"></i> Lihat Produk
                    </a>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light border text-center py-5">
                <i class="bi bi-box-seam fs-1 text-muted"></i>
                <p class="mt-3 mb-0 text-muted">
                    Produk belum tersedia
                </p>
            </div>
        </div>
        @endforelse

    </div>
</div>

{{-- CUSTOM CSS untuk hover effect --}}
<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }
</style>

@endsection