@extends('buyer.layout.buyer')

@section('title', 'Home')
@section('page-title', 'Produk Terbaru')

@section('content')
<div class="row g-4">

    @forelse($products as $product)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm h-100">

            <!-- IMAGE -->
            <div class="ratio ratio-4x3">
                <img
                    src="https://via.placeholder.com/400x300"
                    class="card-img-top object-fit-cover"
                    alt="{{ $product->name }}">
            </div>

            <!-- BODY -->
            <div class="card-body d-flex flex-column">
                <h6 class="fw-semibold mb-1 text-truncate">
                    {{ $product->name }}
                </h6>

                <span class="fw-bold text-success fs-6 mb-3">
                    Rp {{ number_format($product->price,0,',','.') }}
                </span>

                <a href="{{ route('buyer.products.show', $product->id) }}"
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
@endsection