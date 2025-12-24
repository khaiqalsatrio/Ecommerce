@extends('buyer.layout.buyer')

@section('title', $product->name)

@section('content')
<div class="container py-1">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Product Image --}}
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div id="productImageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-top">
                        @if($product->images->count())
                        @foreach($product->images as $key => $img)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <div class="ratio ratio-1x1">
                                <img src="{{ asset('storage/' . $img->image) }}"
                                    class="d-block w-100 h-100"
                                    alt="{{ $product->name }}"
                                    style="object-fit: contain; background-color: #f8f9fa; padding: 20px;">
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="carousel-item active">
                            <div class="ratio ratio-1x1">
                                <div class="bg-light d-flex align-items-center justify-content-center flex-column">
                                    <i class="bi bi-image text-muted mb-3" style="font-size: 100px;"></i>
                                    <p class="text-muted">No Image Available</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Controls --}}
                    @if($product->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    {{-- Indicators --}}
                    <div class="carousel-indicators">
                        @foreach($product->images as $key => $img)
                        <button type="button"
                            data-bs-target="#productImageCarousel"
                            data-bs-slide-to="{{ $key }}"
                            class="{{ $key === 0 ? 'active' : '' }}"
                            aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $key + 1 }}">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Thumbnail Preview --}}
                @if($product->images->count() > 1)
                <div class="d-flex gap-2 p-3 overflow-auto flex-nowrap" style="scrollbar-width: thin;">
                    @foreach($product->images as $key => $img)
                    <button class="border rounded p-1 flex-shrink-0 thumbnail-btn {{ $key === 0 ? 'border-primary border-2' : 'border-secondary' }}"
                        style="width: 80px; height: 80px;"
                        data-bs-target="#productImageCarousel"
                        data-bs-slide-to="{{ $key }}"
                        onclick="setActiveThumbnail(this)">
                        <img src="{{ asset('storage/' . $img->image) }}"
                            class="w-100 h-100 rounded"
                            style="object-fit: cover;">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Product Details --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

                <div class="mb-3">
                    <span class="badge bg-primary fs-6">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>
                </div>

                <h3 class="text-success fw-bold mb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </h3>

                @if($product->description)
                <div class="mb-4">
                    <h5 class="fw-semibold mb-2">Deskripsi Produk</h5>
                    <p class="text-muted" style="text-align: justify;">{{ $product->description }}</p>
                </div>
                @endif

                <div class="mb-4">
                    <h5 class="fw-semibold mb-2">Stok</h5>
                    @if($product->stock > 0)
                    <span class="badge bg-success fs-6">
                        <i class="bi bi-check-circle me-1"></i>
                        Tersedia ({{ $product->stock }} item)
                    </span>
                    @else
                    <span class="badge bg-danger fs-6">
                        <i class="bi bi-x-circle me-1"></i>
                        Stok Habis
                    </span>
                    @endif
                </div>

                {{-- Quantity Selector & Action Buttons --}}
                <form action="{{ route('buyer.cart.add', $product->id) }}" method="POST" id="addToCartForm">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <div class="input-group" style="max-width: 180px;">
                            <button type="button" class="btn btn-outline-secondary px-3" onclick="decreaseQty()">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number"
                                class="form-control text-center fw-semibold"
                                name="quantity"
                                id="quantity"
                                value="1"
                                min="1"
                                max="{{ $product->stock }}"
                                required>
                            <button type="button" class="btn btn-outline-secondary px-3" onclick="increaseQty()">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        @if($product->stock > 0)
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                        </button>

                        <button type="button" class="btn btn-success btn-lg" onclick="buyNow()">
                            <i class="bi bi-bag-check me-2"></i> Beli Sekarang
                        </button>
                        @else
                        <button type="button" class="btn btn-secondary btn-lg" disabled>
                            <i class="bi bi-x-circle me-2"></i> Stok Habis
                        </button>
                        @endif

                        <a href="/" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Produk
                        </a>
                    </div>
                </form>

                {{-- Success/Error Messages --}}
                @if(session('success'))
                <div class="alert alert-success mt-3 alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger mt-3 alert-dismissible fade show">
                    <i class="bi bi-x-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth thumbnail hover effect */
    .thumbnail-btn {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .thumbnail-btn:hover {
        border-color: #0d6efd !important;
        transform: scale(1.05);
    }

    .thumbnail-btn:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    /* Custom scrollbar for thumbnails */
    .overflow-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .overflow-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Responsive carousel height */
    @media (max-width: 768px) {
        .ratio-1x1 {
            aspect-ratio: 1 / 1;
        }
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

    function setActiveThumbnail(element) {
        // Remove active class from all thumbnails
        document.querySelectorAll('.thumbnail-btn').forEach(btn => {
            btn.classList.remove('border-primary', 'border-2');
            btn.classList.add('border-secondary');
        });

        // Add active class to clicked thumbnail
        element.classList.remove('border-secondary');
        element.classList.add('border-primary', 'border-2');
    }

    function buyNow() {
        let form = document.getElementById('addToCartForm');
        let formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/buyer/checkout';
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan ke keranjang');
            });
    }

    // Auto-update thumbnail active state when carousel slides
    document.getElementById('productImageCarousel').addEventListener('slide.bs.carousel', function(e) {
        let thumbnails = document.querySelectorAll('.thumbnail-btn');
        thumbnails.forEach((btn, index) => {
            if (index === e.to) {
                btn.classList.remove('border-secondary');
                btn.classList.add('border-primary', 'border-2');
            } else {
                btn.classList.remove('border-primary', 'border-2');
                btn.classList.add('border-secondary');
            }
        });
    });
</script>
@endsection