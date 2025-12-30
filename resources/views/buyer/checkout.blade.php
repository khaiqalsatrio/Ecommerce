@extends('buyer.layout.buyer')

@section('title', 'Checkout')

@section('content')
<div class="container-fluid px-4 py-2">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold mb-2">Checkout</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('buyer.cart.index') }}" class="text-decoration-none">Keranjang</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>

            <div class="row g-4">
                {{-- LEFT : Detail Produk --}}
                <div class="col-lg-8">
                    {{-- Alamat Pengiriman --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-0 fw-semibold">Alamat Pengiriman</h5>
                                    <small class="text-muted">Alamat utama Anda</small>
                                </div>
                                <a href="{{ route('buyer.profile') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Ubah
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($address)
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="bi bi-geo-alt-fill text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-1 fw-semibold">{{ auth()->user()->name }}</p>
                                    <p class="mb-1 text-muted">
                                        {{ $address->address }}
                                    </p>
                                    <small class="text-muted">
                                        {{ $address->city }},
                                        {{ $address->province }}
                                        {{ $address->postal_code }}
                                    </small>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Anda belum menambahkan alamat.
                                <a href="{{ route('buyer.profile') }}" class="fw-semibold">
                                    Tambah alamat sekarang
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <svg width="24" height="24" fill="currentColor" class="text-primary" viewBox="0 0 16 16">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-semibold">Detail Pesanan</h5>
                                    <small class="text-muted">{{ count($cart->items) }} item dalam keranjang</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 py-3 ps-4">Produk</th>
                                            <th class="border-0 py-3 text-center" width="120">Harga</th>
                                            <th class="border-0 py-3 text-center" width="80">Qty</th>
                                            <th class="border-0 py-3 text-end pe-4" width="150">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart->items as $item)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    {{-- Image --}}
                                                    <div class="col-md-2">
                                                        <img
                                                            src="{{ $item->product->images->first()
                                        ? asset('storage/'.$item->product->images->first()->image)
                                        : 'https://via.placeholder.com/150' }}"
                                                            class="img-fluid rounded"
                                                            style="aspect-ratio: 1/1; object-fit: cover;">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $item->product->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="text-muted">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="badge bg-light text-dark border">{{ $item->qty }}</span>
                                            </td>
                                            <td class="text-end pe-4 py-3">
                                                <strong class="text-primary">Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Info Card --}}
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <svg width="24" height="24" fill="currentColor" class="text-info me-3 flex-shrink-0" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                </svg>
                                <div>
                                    <h6 class="mb-1 fw-semibold">Informasi Penting</h6>
                                    <p class="mb-0 text-muted small">Pastikan detail pesanan Anda sudah benar sebelum melanjutkan ke pembayaran.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT : Ringkasan --}}
                <div class="col-lg-4">
                    <div class="position-sticky" style="top: 20px;">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom py-3">
                                <h5 class="mb-0 fw-semibold">Ringkasan Pesanan</h5>
                            </div>
                            <div class="card-body">
                                {{-- Summary Details --}}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="fw-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Biaya Admin</span>
                                        <span class="fw-medium text-success">Gratis</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Total</h6>
                                            <small class="text-muted">Termasuk pajak</small>
                                        </div>
                                        <h4 class="mb-0 fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                                    </div>
                                </div>

                                {{-- Checkout Button --}}
                                <form id="checkout-form">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold shadow-sm">
                                        <svg width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                        </svg>
                                        Lanjut ke Pembayaran
                                    </button>
                                </form>

                                {{-- Security Badge --}}
                                <div class="mt-4 text-center">
                                    <div class="d-flex align-items-center justify-content-center text-muted small">
                                        <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                            <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                        </svg>
                                        Transaksi Aman & Terpercaya
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Methods Info --}}
                        <div class="card border-0 bg-light mt-3">
                            <div class="card-body p-3">
                                <h6 class="mb-2 fw-semibold small">Metode Pembayaran</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-white border text-dark">Transfer Bank</span>
                                    <span class="badge bg-white border text-dark">E-Wallet</span>
                                    <span class="badge bg-white border text-dark">QRIS</span>
                                    <span class="badge bg-white border text-dark">Kartu Kredit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Load SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Load Midtrans Snap.js - SANDBOX --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const button = this.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;

        // Disable button and show loading
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';

        fetch("{{ route('buyer.checkout.process') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.snap_token) {
                    // Buka Midtrans Snap popup
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            // Redirect ke halaman success
                            window.location.href = "/buyer/order/success/" + data.order_code;
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            // Redirect ke halaman pending
                            window.location.href = "/buyer/order/pending/" + data.order_code;
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Gagal',
                                text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
                                confirmButtonColor: '#dc3545'
                            });
                            button.disabled = false;
                            button.innerHTML = originalText;
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                            // User menutup popup tanpa menyelesaikan pembayaran
                            button.disabled = false;
                            button.innerHTML = originalText;
                        }
                    });
                } else {
                    // ✅ Tampilkan error dengan SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Checkout Gagal',
                        text: data.message || 'Terjadi kesalahan. Silakan coba lagi.',
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'OK'
                    });
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                // ✅ Tampilkan error dengan SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Tidak dapat terhubung ke server. Silakan periksa koneksi internet Anda.',
                    confirmButtonColor: '#dc3545'
                });
                button.disabled = false;
                button.innerHTML = originalText;
            });
    });
</script>
@endpush