@extends('admin.layout.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="container-fluid">
    <!-- Header Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="card-title mb-1 fw-bold">
                        <i class="bi bi-box-seam text-primary"></i> Product List
                    </h4>
                    <p class="text-muted mb-0">Kelola semua produk Anda</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Product
                </a>
            </div>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4" style="width: 60px;">#</th>
                            <th style="width: 100px;">Image</th>
                            <th>Product</th>
                            <th style="width: 150px;">Price</th>
                            <th>Description</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <!-- Number -->
                            <td class="px-4">
                                <span class="badge bg-secondary">{{ $loop->iteration }}</span>
                            </td>

                            <!-- Image -->
                            <td>
                                @if($product->images->count())
                                <img src="{{ asset('storage/'.$product->images->first()->image) }}"
                                    class="rounded border"
                                    style="width: 64px; height: 64px; object-fit: cover;"
                                    alt="{{ $product->name }}">
                                @else
                                <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                                    style="width: 64px; height: 64px;">
                                    <i class="bi bi-image text-muted fs-4"></i>
                                </div>
                                @endif
                            </td>

                            <!-- Product Info -->
                            <td>
                                <div class="fw-semibold text-dark">{{ $product->name }}</div>
                                <small class="text-muted">
                                    <i class="bi bi-box"></i> Stock:
                                    <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} badge-sm">
                                        {{ $product->stock }}
                                    </span>
                                </small>
                            </td>

                            <!-- Price -->
                            <td>
                                <span class="badge bg-success fs-6 fw-normal">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </td>

                            <!-- Description -->
                            <td>
                                <span class="text-muted small">
                                    {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit Product">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.products.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete Product">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox display-1 d-block mb-3"></i>
                                    <h5>No Products Found</h5>
                                    <p class="mb-0">Start by adding your first product</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($products) && method_exists($products, 'hasPages') && $products->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection