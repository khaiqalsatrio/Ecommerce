@extends('admin.layout.admin')

@section('title', 'Add Product')
@section('page-title', 'Add Product')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="mb-1 fw-bold">
                <i class="bi bi-plus-circle text-primary"></i> Add New Product
            </h4>
            <p class="text-muted mb-0">Tambahkan produk baru ke katalog Anda</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <!-- Error Alert -->
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-2">Terdapat beberapa kesalahan:</h6>
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Category -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
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

                    <!-- Price -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Price <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi"></i> Rp
                            </span>
                            <input type="number"
                                name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}"
                                placeholder="0"
                                min="0"
                                required>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Masukkan harga dalam Rupiah</small>
                    </div>

                    <!-- Product Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Product Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Contoh: kopi arabica"
                            required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Stock <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                            name="stock"
                            class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock') }}"
                            placeholder="0"
                            min="0"
                            required>
                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Jumlah stok yang tersedia</small>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description"
                            rows="5"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Tuliskan deskripsi lengkap produk Anda...">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Deskripsi singkat tentang produk (opsional)
                        </small>
                    </div>

                    <!-- Product Images -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Product Images</label>
                        <input type="file"
                            name="images[]"
                            class="form-control @error('images.*') is-invalid @enderror"
                            multiple
                            accept="image/jpeg,image/png,image/jpg,image/webp">
                        @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-image"></i> Bisa upload lebih dari 1 gambar (JPG, PNG, WEBP, max 2MB per file)
                        </small>
                    </div>
                </div>

                <!-- Divider -->
                <hr class="my-4">

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Helper Info Card -->
    <div class="card shadow-sm mt-4 border-info">
        <div class="card-body">
            <h6 class="card-title text-info mb-3">
                <i class="bi bi-lightbulb"></i> Tips untuk menambahkan produk:
            </h6>
            <ul class="mb-0 small text-muted">
                <li>Gunakan nama produk yang jelas dan deskriptif</li>
                <li>Upload gambar produk dengan kualitas baik untuk meningkatkan daya tarik</li>
                <li>Pastikan harga dan stok sudah benar sebelum menyimpan</li>
                <li>Deskripsi yang lengkap membantu pelanggan memahami produk dengan lebih baik</li>
            </ul>
        </div>
    </div>
</div>
@endsection