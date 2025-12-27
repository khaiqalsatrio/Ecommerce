@extends('buyer.layout.buyer')

@section('title', 'Products')

@section('content')
<div class="container py-2">
    
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Daftar Produk</h2>
                    <p class="text-muted mb-0">Temukan produk berkualitas untuk kebutuhan Anda</p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        {{ $products->count() }} Produk Tersedia
                    </span>
                </div>
            </div>
            <hr class="mt-3">
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        @forelse ($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm position-relative overflow-hidden" 
                 style="transition: all 0.3s ease;">
                
                <!-- Badge Kategori -->
                @if($product->category)
                <div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
                    <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1" 
                          style="font-size: 0.7rem;">
                        {{ $product->category->name }}
                    </span>
                </div>
                @endif

                <!-- Image Carousel -->
                @if($product->images->count() > 1)
                <div id="carousel{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner ratio ratio-1x1">
                        @foreach($product->images as $key => $img)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/'.$img->image) }}"
                                 class="d-block w-100 h-100 object-fit-cover"
                                 alt="{{ $product->name }}"
                                 style="cursor: pointer;">
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" 
                            data-bs-target="#carousel{{ $product->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark bg-opacity-50 rounded-circle p-3" 
                              aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" 
                            data-bs-target="#carousel{{ $product->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark bg-opacity-50 rounded-circle p-3" 
                              aria-hidden="true"></span>
                    </button>

                    <!-- Indicators -->
                    <div class="carousel-indicators" style="margin-bottom: 0.5rem;">
                        @foreach($product->images as $key => $img)
                        <button type="button" 
                                data-bs-target="#carousel{{ $product->id }}" 
                                data-bs-slide-to="{{ $key }}"
                                class="{{ $key === 0 ? 'active' : '' }}"
                                style="width: 6px; height: 6px; border-radius: 50%;">
                        </button>
                        @endforeach
                    </div>
                </div>
                @else
                <!-- Single Image -->
                <div class="ratio ratio-1x1">
                    @if($product->images->count())
                    <img src="{{ asset('storage/'.$product->images->first()->image) }}"
                         class="w-100 h-100 object-fit-cover"
                         alt="{{ $product->name }}">
                    @else
                    <div class="d-flex align-items-center justify-content-center bg-light">
                        <div class="text-center text-muted">
                            <i class="bi bi-image" style="font-size: 3rem;"></i>
                            <p class="mt-2 mb-0 small">No Image</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Card Body -->
                <div class="card-body d-flex flex-column p-3">
                    <h6 class="card-title fw-semibold mb-2 text-truncate" 
                        title="{{ $product->name }}">
                        {{ $product->name }}
                    </h6>

                    <div class="mt-auto">
                        <!-- Price -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <div class="text-success fw-bold" style="font-size: 1.1rem;">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="btn btn-success w-100 btn-sm d-flex align-items-center justify-content-center gap-1"
                           style="transition: all 0.3s ease;">
                            <i class="bi bi-cart-plus"></i>
                            <span>Lihat Detail</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                </div>
                <h5 class="text-muted mb-2">Belum Ada Produk</h5>
                <p class="text-muted">Produk akan segera tersedia. Silakan cek kembali nanti.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination (jika ada) -->
    @if(method_exists($products, 'links'))
    <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
    @endif

</div>

<style>
    /* Hover Effects */
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .btn-success:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    /* Carousel Controls Hover */
    .carousel-control-prev:hover .carousel-control-prev-icon,
    .carousel-control-next:hover .carousel-control-next-icon {
        background-color: rgba(0,0,0,0.7) !important;
    }

    /* Smooth Image Loading */
    .card img {
        transition: transform 0.3s ease;
    }

    .card:hover img {
        transform: scale(1.05);
    }

    /* Prevent image zoom overflow */
    .carousel-inner,
    .ratio {
        overflow: hidden;
    }
</style>
@endsection