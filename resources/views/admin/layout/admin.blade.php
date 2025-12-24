<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #212529;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar .active {
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="d-flex">

        {{-- SIDEBAR --}}
        <aside class="sidebar p-3">
            <h4 class="text-white mb-4">Admin Panel</h4>

            <ul class="nav flex-column gap-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link rounded px-3 {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link rounded px-3 {{ request()->routeIs('admin.product') ? 'active' : '' }}">
                        <i class="bi bi-box-seam me-2"></i> Products
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="nav-link rounded px-3 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags me-2"></i> Categories
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link rounded px-3 {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                        <i class="bi bi-receipt me-2"></i> Orders
                    </a>
                </li>

                <li class="mt-3">
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="btn btn-danger w-100">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        {{-- CONTENT --}}
        <main class="flex-fill p-4">
            <h3 class="mb-4">@yield('page-title')</h3>
            @yield('content')
        </main>

    </div>

</body>

</html>