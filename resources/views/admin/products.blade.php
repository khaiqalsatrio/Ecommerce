@extends('admin.layout.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <h5 class="mb-0 fw-semibold">Product List</h5>

            <a href="{{ route('admin.products.create') }}"
                class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-circle me-1"></i> Add Product
            </a>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Product</th>
                        <th style="width:150px;">Price</th>
                        <th>Description</th>
                        <th style="width:150px;" class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="fw-semibold">{{ $loop->iteration }}</td>

                        {{-- PRODUCT --}}
                        <td>
                            <div class="fw-semibold">{{ $product->name }}</div>
                            <small class="text-muted">
                                Stock: {{ $product->stock }}
                            </small>
                        </td>

                        {{-- PRICE --}}
                        <td>
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- DESCRIPTION --}}
                        <td>
                            <span class="text-muted">
                                {{ \Illuminate\Support\Str::limit($product->description, 60) }}
                            </span>
                        </td>

                        {{-- ACTION --}}
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-sm btn-outline-warning rounded-pill">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('admin.products.destroy', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-box-seam fs-4 d-block mb-2"></i>
                            No products found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>
@endsection