<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MyShop</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: whitesmoke;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .login-card h4 {
            font-weight: 700;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
        }

        .form-control:focus {
            border-color: #212529;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .btn-login {
            background: #212529;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #4f4f51ff;
        }

        .login-footer a {
            text-decoration: none;
            font-weight: 500;
        }

        .brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #212529;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-10">

                <div class="login-card">

                    <div class="text-center mb-4">
                        <div class="brand mb-1">
                            <i class="bi bi-shop"></i> MyShop
                        </div>
                        <p class="text-muted mb-0">Welcome back! Please login</p>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger small text-center">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100 text-white">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </button>
                    </form>

                    <div class="login-footer text-center mt-4">
                        <small class="text-muted">
                            Don’t have an account?
                            <a href="/register" class="text-primary">Register</a>
                        </small>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>

</html>