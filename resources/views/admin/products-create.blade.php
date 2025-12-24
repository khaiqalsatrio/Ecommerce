@extends('admin.layout.admin')

@section('title', 'Add Product')
@section('page-title', 'Add Product')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        {{-- ERROR GLOBAL --}}
        @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                {{-- CATEGORY --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="category_id"
                        class="form-select rounded-3 @error('category_id') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PRICE --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number"
                            name="price"
                            class="form-control rounded-end-3 @error('price') is-invalid @enderror"
                            value="{{ old('price') }}"
                            required>
                    </div>
                    @error('price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PRODUCT NAME --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Product Name</label>
                    <input type="text"
                        name="name"
                        class="form-control rounded-3 @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Nama produk"
                        required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- STOCK --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Stock</label>
                    <input type="number"
                        name="stock"
                        class="form-control rounded-3 @error('stock') is-invalid @enderror"
                        value="{{ old('stock') }}"
                        placeholder="Jumlah stok"
                        required>
                    @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="form-control rounded-3 @error('description') is-invalid @enderror"
                        placeholder="Deskripsi produk...">{{ old('description') }}</textarea>
                    <small class="text-muted">
                        Deskripsi singkat tentang produk (opsional)
                    </small>
                    @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>

                <button type="submit"
                    class="btn btn-primary rounded-pill px-5">
                    <i class="bi bi-save me-1"></i> Save Product
                </button>
            </div>

        </form>
    </div>
</div>
@endsection