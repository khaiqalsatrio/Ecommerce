
@extends('buyer.layout.buyer')

@section('title', 'Home')

@section('content')

{{-- HERO BANNER --}}
<div class="hero-slider">
    <!-- {{-- Slide 1 - YouTube Video --}}
    <div class="hero-slide">
        <div class="hero-video-wrapper">
            <iframe
                class="hero-video"
                src="https://www.youtube.com/embed/0NH_gFR-4EI?autoplay=1&mute=1&loop=1&playlist=0NH_gFR-4EI&controls=0&showinfo=0&rel=0&modestbranding=1"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
        </div>
        <div class="hero-content">
            <h1>Selamat Datang di MyCoffee</h1>
            <p>Temukan produk berkualitas dengan harga terbaik</p>
            <a href="#" class="btn btn-primary">Belanja Sekarang</a>
        </div>
    </div> -->

    {{-- Slide 2 - YouTube Video --}}
    <div class="hero-slide">
        <div class="hero-video-wrapper">
            <iframe
                class="hero-video"
                src="https://www.youtube.com/embed/AGDGZfsQ2fk?autoplay=1&mute=1&loop=1&playlist=AGDGZfsQ2fk&controls=0&showinfo=0&rel=0&modestbranding=1"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
        </div>
        <div class="hero-content">
            <h1>Promo Spesial</h1>
            <p>Diskon hingga 50% untuk produk pilihan</p>
            <a href="#" class="btn btn-primary">Lihat Promo</a>
        </div>
    </div>

    {{-- Slide 3 - YouTube Video --}}
    <div class="hero-slide">
        <div class="hero-video-wrapper">
            <iframe
                class="hero-video"
                src="https://www.youtube.com/embed/x-wH0uoraI0?autoplay=1&mute=1&loop=1&playlist=x-wH0uoraI0&controls=0&showinfo=0&rel=0&modestbranding=1"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
        </div>
        <div class="hero-content">
            <h1>Gratis Ongkir</h1>
            <p>Untuk pembelian minimal Rp 100.000</p>
            <a href="#" class="btn btn-primary">Belanja Sekarang</a>
        </div>
    </div>

    <button class="slider-btn prev">Previous</button>
    <button class="slider-btn next">Next</button>
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

                    <a href="{{ route('products.show', $product->slug) }}" {{-- Pakai slug --}}
                        class="btn btn-outline-success btn-sm mt-auto w-100">
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

    .hero-slider {
        position: relative;
        width: 100%;
        height: 500px;
        overflow: hidden;
        background: #000;
        margin-bottom: 8px;
        border-radius: 5px;
    }

    .hero-slide {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    .hero-slide.active {
        opacity: 1;
    }

    .hero-video-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .hero-video {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100vw;
        height: 56.25vw;
        /* Ratio 16:9 */
        min-height: 100vh;
        min-width: 177.77vh;
        /* Ratio 16:9 */
        transform: translate(-50%, -50%);
    }

    .hero-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        z-index: 2;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
        background: rgba(0, 0, 0, 0.3);
        padding: 2rem 3rem;
        border-radius: 10px;
    }

    .hero-content h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }

    .hero-content p {
        font-size: 1.5rem;
        margin-bottom: 2rem;
    }

    .btn-primary {
        background: #ff6b6b;
        color: white;
        padding: 1rem 2rem;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        transition: background 0.3s;
    }

    .btn-primary:hover {
        background: #ff5252;
    }

    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 1rem 1.5rem;
        cursor: pointer;
        z-index: 3;
        transition: background 0.3s;
        font-size: 1rem;
    }

    .slider-btn:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .slider-btn.prev {
        left: 20px;
    }

    .slider-btn.next {
        right: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-slider {
            height: 400px;
        }

        .hero-content h1 {
            font-size: 2rem;
        }

        .hero-content p {
            font-size: 1rem;
        }

        .slider-btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }
</style>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const prevBtn = document.querySelector('.slider-btn.prev');
        const nextBtn = document.querySelector('.slider-btn.next');
        let currentSlide = 0;

        // Show first slide
        slides[0].classList.add('active');

        function showSlide(n) {
            slides[currentSlide].classList.remove('active');
            currentSlide = (n + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        }

        prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
        nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));

        // Auto slide every 8 seconds (lebih lama untuk video)
        setInterval(() => showSlide(currentSlide + 1), 8000);
    });
</script>