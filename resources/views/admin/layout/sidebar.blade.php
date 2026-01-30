<style>
    .sidebar {
        width: 260px;
        min-height: 100vh;
        background: linear-gradient(180deg, #1f2933, #111827);
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.4);
    }

    .sidebar h4 {
        font-weight: 700;
        letter-spacing: 1px;
    }

    .sidebar .nav-link {
        color: #9ca3af;
        padding: 12px 16px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .sidebar .nav-link i {
        font-size: 1.1rem;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.08);
        color: #fff;
        transform: translateX(6px);
    }

    .sidebar .nav-link.active {
        background: linear-gradient(90deg, #2563eb, #3b82f6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .sidebar .logout-btn {
        background: linear-gradient(90deg, #dc2626, #ef4444);
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .sidebar .logout-btn:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
    }
</style>


{{-- resources/views/admin/layout/sidebar.blade.php --}}
<aside class="sidebar p-4">
    <h4 class="text-white mb-4 text-center">
        <i class="bi bi-grid-fill me-2"></i> Admin Panel
    </h4>

    <ul class="nav flex-column gap-2">
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('admin.products.index') }}"
                class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>

        <li>
            <a href="{{ route('admin.categories.index') }}"
                class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Categories
            </a>
        </li>

        <li>
            <a href="{{ route('admin.orders.index') }}"
                class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Orders
            </a>
        </li>

        <li>
            <a href="{{ route('admin.data-user') }}"
                class="nav-link {{ request()->routeIs('admin.data-user') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Data User
            </a>
        </li>


        <li class="mt-4">
            <form action="/logout" method="POST">
                @csrf
                <button class="logout-btn w-100 text-white">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</aside>