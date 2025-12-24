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
    </style>
</head>

<body>

    <div class="d-flex">

        {{-- SIDEBAR --}}
        @include('admin.layout.sidebar')

        {{-- CONTENT --}}
        <main class="flex-fill p-4">
            <h3 class="mb-4">@yield('page-title')</h3>
            @yield('content')
        </main>

    </div>

</body>

</html>