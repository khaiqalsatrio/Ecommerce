@extends('buyer.layout.buyer')

@section('title', $product->name)

@section('content')
<div class="container py-3 py-md-2">
    <!-- Modern Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white shadow-sm rounded-pill px-4 py-2 mb-0">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none text-primary">
                    <i class="bi bi-house-door-fill"></i>
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}" class="text-decoration-none">Produk</a>
            </li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 200px;">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Product Image Section --}}
        <div class="col-12 col-lg-6">
            <div class="position-relative">
                {{-- Main Carousel with Glass Effect --}}
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
                    <div id="productImageCarousel" class="carousel slide">
                        <div class="carousel-inner">
                            @if($product->images->count())
                            @foreach($product->images as $key => $img)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <div class="ratio ratio-1x1 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <img src="{{ asset('storage/' . $img->image) }}"
                                        class="d-block w-100 h-100 p-4"
                                        alt="{{ $product->name }}"
                                        style="object-fit: contain; mix-blend-mode: multiply;"
                                        role="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imageModal">
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="carousel-item active">
                                <div class="ratio ratio-1x1 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <div class="d-flex align-items-center justify-content-center flex-column text-white">
                                        <i class="bi bi-image" style="font-size: 5rem; opacity: 0.3;"></i>
                                        <p class="mt-3 opacity-75">No Image</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Modern Carousel Controls --}}
                        @if($product->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                            <div class="bg-white bg-opacity-90 rounded-circle p-2 shadow">
                                <i class="bi bi-chevron-left text-dark fs-5"></i>
                            </div>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                            <div class="bg-white bg-opacity-90 rounded-circle p-2 shadow">
                                <i class="bi bi-chevron-right text-dark fs-5"></i>
                            </div>
                        </button>

                        {{-- Modern Indicators --}}
                        <div class="carousel-indicators mb-3">
                            @foreach($product->images as $key => $img)
                            <button type="button"
                                data-bs-target="#productImageCarousel"
                                data-bs-slide-to="{{ $key }}"
                                class="{{ $key === 0 ? 'active' : '' }}"
                                style="width: 8px; height: 8px; border-radius: 50%; margin: 0 4px;"></button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- Floating Badge --}}
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2 shadow">
                            <i class="bi bi-images"></i> {{ $product->images->count() }} Foto
                        </span>
                    </div>

                    {{-- Zoom Hint --}}
                    <div class="position-absolute bottom-0 end-0 m-3">
                        <span class="badge bg-white bg-opacity-75 rounded-pill px-3 py-2 shadow-sm">
                            <i class="bi bi-zoom-in text-dark"></i>
                        </span>
                    </div>
                </div>

                {{-- Modern Thumbnail Gallery --}}
                @if($product->images->count() > 1)
                <div class="mt-3">
                    <div class="d-flex gap-2 overflow-auto pb-2">
                        @foreach($product->images as $key => $img)
                        <button class="btn p-0 border-0 flex-shrink-0 thumbnail-btn {{ $key === 0 ? 'active' : '' }}"
                            data-bs-target="#productImageCarousel"
                            data-bs-slide-to="{{ $key }}"
                            style="width: 70px; height: 70px; border-radius: 12px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                class="w-100 h-100"
                                style="object-fit: cover;"
                                alt="Thumbnail {{ $key + 1 }}">
                            <div class="thumbnail-overlay"></div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Product Details Section --}}
        <div class="col-12 col-lg-6">
            <div class="h-100">
                {{-- Category Badge Modern --}}
                <div class="mb-3">
                    <span class="badge text-primary border border-primary rounded-pill px-3 py-2 fs-6 fw-normal">
                        <i class="bi bi-tag-fill"></i>
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>
                </div>

                {{-- Product Name --}}
                <h1 class="display-6 fw-bold mb-3">{{ $product->name }}</h1>

                {{-- Price Card Modern --}}
                <div class="card border-0 shadow-sm mb-3" style="background: black; border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="text-white text-opacity-75 mb-1 small">Harga Produk</p>
                                <h2 class="text-white fw-bold mb-0 fs-3">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </h2>
                            </div>
                            <div class="col-4 text-end">
                                @if($product->stock > 0)
                                <div class="bg-white bg-opacity-20 rounded-pill px-3 py-2 d-inline-block">
                                    <i class="bi bi-check-circle-fill text-white"></i>
                                    <span class="text-white small d-none d-md-inline ms-1">Tersedia</span>
                                </div>
                                @else
                                <div class="bg-danger bg-opacity-20 rounded-pill px-3 py-2 d-inline-block">
                                    <i class="bi bi-x-circle-fill text-white"></i>
                                    <span class="text-white small d-none d-md-inline ms-1">Habis</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stock Info Modern --}}
                <div class="card border-0 bg-light mb-3" style="border-radius: 16px;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-box-seam text-primary fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-0 small text-muted">Stok Tersedia</p>
                                <p class="mb-0 fw-bold fs-5">{{ $product->stock }} <span class="small text-muted">Unit</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description Modern --}}
                @if($product->description)
                <div class="card border-0 bg-light mb-3" style="border-radius: 16px;">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-card-text text-primary fs-5 me-2"></i>
                            <h5 class="mb-0 fw-bold">Deskripsi Produk</h5>
                        </div>
                        <p class="text-muted mb-0" style="line-height: 1.8;">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>
                @endif

                {{-- Add to Cart Form Modern --}}
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('buyer.cart.add', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            {{-- Quantity Selector Modern --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-3">
                                    <i class="bi"></i> Jumlah Pembelian
                                </label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="input-group shadow-sm" style="width: 150px; border-radius: 12px; overflow: hidden;">
                                        <button type="button"
                                            class="btn btn-light border-0"
                                            onclick="decreaseQty()"
                                            style="width: 45px;">
                                            <i class="bi bi-dash-lg fw-bold"></i>
                                        </button>
                                        <input type="number"
                                            class="form-control text-center fw-bold border-0 bg-light"
                                            name="qty"
                                            id="quantity"
                                            value="1"
                                            min="1"
                                            max="{{ $product->stock }}"
                                            required>
                                        <button type="button"
                                            class="btn btn-light border-0"
                                            onclick="increaseQty()"
                                            style="width: 45px;">
                                            <i class="bi bi-plus-lg fw-bold"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">/ {{ $product->stock }} unit</small>
                                </div>
                            </div>

                            {{-- Action Button Modern --}}
                            @if($product->stock > 0)
                            <button type="submit" class="btn btn-lg w-100 text-white fw-bold shadow-lg"
                                style="background: black; border-radius: 12px; border: none;">
                                <i class="bi bi-cart-plus-fill me-2"></i>
                                Tambah ke Keranjang
                            </button>
                            @else
                            <button type="button" class="btn btn-secondary btn-lg w-100 fw-bold"
                                style="border-radius: 12px;" disabled>
                                <i class="bi bi-x-circle me-2"></i>
                                Stok Tidak Tersedia
                            </button>
                            @endif
                        </form>
                    </div>
                </div>

                {{-- Messages --}}
                @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mt-3"
                    style="border-radius: 12px;" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div class="flex-grow-1">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mt-3"
                    style="border-radius: 12px;" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div class="flex-grow-1">{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modern Image Zoom Modal --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark bg-opacity-95 border-0" style="border-radius: 20px;">
            <div class="modal-header border-0">
                <button type="button"
                    class="btn-close btn-close-white ms-auto"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 p-md-5">
                <div id="modalCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        @if($product->images->count())
                        @foreach($product->images as $key => $img)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                class="d-block w-100 rounded-3"
                                alt="{{ $product->name }}"
                                style="max-height: 80vh; object-fit: contain;">
                        </div>
                        @endforeach
                        @endif
                    </div>

                    @if($product->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-chevron-left text-white fs-4"></i>
                        </div>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-chevron-right text-white fs-4"></i>
                        </div>
                    </button>

                    <div class="carousel-indicators">
                        @foreach($product->images as $key => $img)
                        <button type="button"
                            data-bs-target="#modalCarousel"
                            data-bs-slide-to="{{ $key }}"
                            class="{{ $key === 0 ? 'active' : '' }}"
                            style="width: 10px; height: 10px; border-radius: 50%; margin: 0 5px;"></button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Minimal CSS untuk efek modern */
    .thumbnail-btn {
        position: relative;
        transition: transform 0.2s;
    }

    .thumbnail-btn:hover {
        transform: scale(1.05);
    }

    .thumbnail-btn.active {
        box-shadow: 0 0 0 3px #667eea;
    }

    .thumbnail-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        opacity: 0;
        transition: opacity 0.2s;
    }

    .thumbnail-btn:hover .thumbnail-overlay {
        opacity: 1;
    }

    .thumbnail-btn.active .thumbnail-overlay {
        opacity: 0;
    }

    /* Smooth scrollbar */
    .overflow-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }
</style>

<script>
    function decreaseQty() {
        let qty = document.getElementById('quantity');
        if (qty.value > 1) {
            qty.value = parseInt(qty.value) - 1;
        }
    }

    function increaseQty() {
        let qty = document.getElementById('quantity');
        let max = parseInt(qty.getAttribute('max'));
        if (qty.value < max) {
            qty.value = parseInt(qty.value) + 1;
        }
    }

    // Sync modal carousel dengan main carousel
    document.getElementById('imageModal').addEventListener('show.bs.modal', function() {
        let mainCarousel = bootstrap.Carousel.getInstance(document.getElementById('productImageCarousel'));
        let modalCarousel = new bootstrap.Carousel(document.getElementById('modalCarousel'));

        if (mainCarousel) {
            let activeIndex = Array.from(document.querySelectorAll('#productImageCarousel .carousel-item'))
                .findIndex(item => item.classList.contains('active'));
            modalCarousel.to(activeIndex);
        }
    });

    // Sync thumbnail dengan carousel
    document.getElementById('productImageCarousel').addEventListener('slide.bs.carousel', function(e) {
        let thumbnails = document.querySelectorAll('.thumbnail-btn');
        thumbnails.forEach((btn, index) => {
            if (index === e.to) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    });

    // Validasi quantity input
    document.getElementById('quantity').addEventListener('input', function() {
        let max = parseInt(this.getAttribute('max'));
        let value = parseInt(this.value);

        if (value > max) this.value = max;
        if (value < 1 || isNaN(value)) this.value = 1;
    });
</script>
@endsection