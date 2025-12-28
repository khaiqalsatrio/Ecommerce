@extends('buyer.layout.buyer')

@section('title', $product->name)

@section('content')
<div class="container py-1">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">
                    <i class="bi bi-house-door"></i> Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}" class="text-decoration-none">Products</a>
            </li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- Product Images -->
        <div class="col-12 col-lg-6">
            <!-- Main Image Carousel -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body p-0">
                    <div id="productImageCarousel" class="carousel slide">
                        <div class="carousel-inner">
                            @if($product->images->count())
                            @foreach($product->images as $key => $img)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <div class="ratio ratio-1x1">
                                    <img src="{{ asset('storage/' . $img->image) }}"
                                        class="d-block w-100 object-fit-contain p-4 cursor-pointer"
                                        alt="{{ $product->name }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        style="cursor: pointer;">
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="carousel-item active">
                                <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image display-1"></i>
                                        <p class="mt-2">No Image Available</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($product->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                        @endif
                    </div>

                    <!-- Image Counter Badge -->
                    @if($product->images->count() > 0)
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-dark bg-opacity-75">
                            <i class="bi bi-images"></i> {{ $product->images->count() }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Thumbnail Gallery -->
            @if($product->images->count() > 1)
            <div class="d-flex gap-2 overflow-auto">
                @foreach($product->images as $key => $img)
                <button class="btn p-0 border {{ $key === 0 ? 'border-primary border-2' : '' }} flex-shrink-0 thumbnail-btn"
                    data-bs-target="#productImageCarousel"
                    data-bs-slide-to="{{ $key }}"
                    style="width: 80px; height: 80px;">
                    <img src="{{ asset('storage/' . $img->image) }}"
                        class="w-100 h-100 object-fit-cover rounded"
                        alt="Thumbnail {{ $key + 1 }}">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-12 col-lg-6">
            <!-- Category Badge -->
            <div class="mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">
                    <i class="bi bi-tag-fill"></i> {{ $product->category->name ?? 'Uncategorized' }}
                </span>
            </div>

            <!-- Product Name -->
            <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>

            <!-- Price Card -->
            <div class="card bg-dark text-white mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-white-50 d-block mb-1">Price</small>
                            <h3 class="mb-0 fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                        </div>
                        <div>
                            @if($product->stock > 0)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Available
                            </span>
                            @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle"></i> Out of Stock
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Info -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                            <i class="bi bi-box-seam text-primary fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Stock Available</small>
                            <strong class="fs-5">{{ $product->stock }} <span class="text-muted small">units</span></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($product->description)
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-card-text text-primary"></i> Product Description
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">{{ $product->description }}</p>
                </div>
            </div>
            @endif

            <!-- Add to Cart Form -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('buyer.cart.add', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Quantity Selector -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-123"></i> Quantity
                            </label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="input-group" style="width: 150px;">
                                    <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="decreaseQty()">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number"
                                        class="form-control text-center"
                                        name="qty"
                                        id="quantity"
                                        value="1"
                                        min="1"
                                        max="{{ $product->stock }}"
                                        required>
                                    <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="increaseQty()">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Max: {{ $product->stock }} units</small>
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        @if($product->stock > 0)
                        <button type="submit" class="btn btn-dark btn-lg w-100 fw-bold">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                        @else
                        <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="bi bi-x-circle"></i> Out of Stock
                        </button>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Product Features -->
            <div class="card mt-3 border-info">
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <i class="bi bi-shield-check text-success fs-3 d-block mb-2"></i>
                            <small class="text-muted">Secure Payment</small>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-truck text-primary fs-3 d-block mb-2"></i>
                            <small class="text-muted">Fast Delivery</small>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-arrow-repeat text-info fs-3 d-block mb-2"></i>
                            <small class="text-muted">Easy Returns</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Zoom Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="modalCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        @if($product->images->count())
                        @foreach($product->images as $key => $img)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                class="d-block w-100 rounded"
                                style="max-height: 80vh; object-fit: contain;"
                                alt="{{ $product->name }}">
                        </div>
                        @endforeach
                        @endif
                    </div>

                    @if($product->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                    <div class="carousel-indicators">
                        @foreach($product->images as $key => $img)
                        <button type="button"
                            data-bs-target="#modalCarousel"
                            data-bs-slide-to="{{ $key }}"
                            class="{{ $key === 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Thumbnail hover effect */
    .thumbnail-btn {
        transition: all 0.2s ease;
    }

    .thumbnail-btn:hover {
        transform: scale(1.05);
    }

    .thumbnail-btn.active {
        border-color: var(--bs-primary) !important;
        border-width: 2px !important;
    }

    /* Custom scrollbar for thumbnails */
    .overflow-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-auto::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    .overflow-auto::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.3);
    }
</style>

<script>
    // Quantity controls
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

    // Validate quantity input
    document.getElementById('quantity').addEventListener('input', function() {
        let max = parseInt(this.getAttribute('max'));
        let value = parseInt(this.value);

        if (value > max) this.value = max;
        if (value < 1 || isNaN(value)) this.value = 1;
    });

    // Sync modal carousel with main carousel
    document.getElementById('imageModal')?.addEventListener('show.bs.modal', function() {
        let mainCarousel = bootstrap.Carousel.getInstance(document.getElementById('productImageCarousel'));
        let modalCarousel = new bootstrap.Carousel(document.getElementById('modalCarousel'), {
            interval: false
        });

        if (mainCarousel) {
            let activeIndex = Array.from(document.querySelectorAll('#productImageCarousel .carousel-item'))
                .findIndex(item => item.classList.contains('active'));
            modalCarousel.to(activeIndex);
        }
    });

    // Update thumbnail active state
    document.getElementById('productImageCarousel')?.addEventListener('slide.bs.carousel', function(e) {
        let thumbnails = document.querySelectorAll('.thumbnail-btn');
        thumbnails.forEach((btn, index) => {
            if (index === e.to) {
                btn.classList.add('border-primary', 'border-2');
                btn.classList.remove('border');
            } else {
                btn.classList.add('border');
                btn.classList.remove('border-primary', 'border-2');
            }
        });
    });
</script>
@endsection