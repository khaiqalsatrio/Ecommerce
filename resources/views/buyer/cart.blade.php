@extends('buyer.layout.buyer')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-2">

    <h3 class="fw-bold mb-4">
        <i class="bi bi-cart3 me-2"></i> Keranjang Belanja
    </h3>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(!$cart || $cart->items->count() == 0)
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-cart-x text-muted" style="font-size: 80px;"></i>
            <h5 class="mt-3">Keranjang masih kosong</h5>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                Mulai Belanja
            </a>
        </div>
    </div>
    @else

    <div class="row">
        {{-- Cart Items --}}
        <div class="col-md-8">
            @php $total = 0; @endphp

            @foreach($cart->items as $item)
            @php
            $subtotal = $item->qty * $item->price;
            $total += $subtotal;
            @endphp

            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">

                        {{-- Image --}}
                        <div class="col-md-2">
                            <img
                                src="{{ $item->product->images->first()
                                        ? asset('storage/'.$item->product->images->first()->image)
                                        : 'https://via.placeholder.com/150' }}"
                                class="img-fluid rounded"
                                style="aspect-ratio: 1/1; object-fit: cover;">
                        </div>

                        {{-- Info --}}
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                            <small class="text-muted">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </small>
                        </div>

                        {{-- Qty --}}
                        <div class="col-md-3">
                            <div class="input-group input-group-sm">
                                <form action="{{ route('buyer.cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-outline-secondary"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.form.submit();"
                                            type="button">-</button>

                                        <input type="number"
                                            name="qty"
                                            class="form-control text-center"
                                            value="{{ $item->qty }}"
                                            min="1"
                                            max="{{ $item->product->stock }}"
                                            onchange="this.form.submit()">

                                        <button class="btn btn-outline-secondary"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.form.submit();"
                                            type="button">+</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Subtotal --}}
                        <div class="col-md-2 fw-bold text-success">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </div>

                        {{-- Remove --}}
                        <div class="col-md-1 text-end">
                            <form action="{{ route('buyer.cart.remove', $item->id) }}" method="POST"
                                onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Summary --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Total</span>
                        <span class="fw-bold text-success">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    <hr>

                    <a href="{{ route('buyer.checkout.show') }}" class="btn btn-success w-100">
                        <i class="bi bi-bag-check me-2"></i>
                        Checkout
                    </a>

                    <a href="{{ route('products.index') }}"
                        class="btn btn-outline-secondary w-100 mt-2">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection