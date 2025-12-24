@extends('admin.layout.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">

        {{-- ADD CATEGORY --}}
        <form action="{{ route('admin.categories.store') }}"
            method="POST"
            class="row g-2 align-items-end mb-4">
            @csrf

            <div class="col-md-9">
                <label class="form-label fw-semibold">Category Name</label>
                <input type="text"
                    name="name"
                    class="form-control"
                    placeholder="Enter category name"
                    required>
            </div>

            <div class="col-md-3 d-grid">
                <button class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add Category
                </button>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Name</th>
                        <th style="width:120px;" class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $loop->iteration }}</td>

                        <td>{{ $category->name }}</td>

                        <td class="text-end">
                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus kategori ini?')"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="bi bi-tags fs-4 d-block mb-2"></i>
                            No categories found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>
@endsection