@extends('admin.layout.admin')

@section('title', 'Data User')
@section('page-title', 'Data User')

@section('content')
<div class="container-fluid">

    <!-- Header Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="card-title mb-1 fw-bold">
                        <i class="bi bi-people text-primary"></i> User List
                    </h4>
                    <p class="text-muted mb-0">Kelola semua user terdaftar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4" style="width: 60px;">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th style="width: 120px;">Role</th>
                            <th style="width: 120px;">Status</th>
                            <th class="text-center" style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <!-- Number -->
                            <td class="px-4">
                                <span class="badge bg-secondary">{{ $loop->iteration }}</span>
                            </td>

                            <!-- Name -->
                            <td>
                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                <small class="text-muted">
                                    <i class="bi bi-person-circle"></i>
                                    ID: {{ $user->id }}
                                </small>
                            </td>

                            <!-- Email -->
                            <td>
                                <span class="text-muted">{{ $user->email }}</span>
                            </td>

                            <!-- Role -->
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'info' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td>
                                <div class="d-flex gap-2 justify-content-center">

                                    <!-- Detail -->
                                    <a href="{{ route('admin.data-user') }}"
                                        class="btn btn-sm btn-outline-info"
                                        title="Detail User">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="#"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit User">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
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
                                    <i class="bi bi-people display-1 d-block mb-3"></i>
                                    <h5>No Users Found</h5>
                                    <p class="mb-0">Belum ada user yang terdaftar</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection