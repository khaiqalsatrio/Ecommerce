<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | MyShop</title>

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

        .register-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .register-card h4 {
            font-weight: 700;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
        }

        .form-control:focus {
            border-color: #212529;
            box-shadow: #212529;
        }

        .btn-register {
            background: #212529;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }

        .btn-register:hover {
            background: #4f4f51ff;
        }

        .brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #212529;
        }

        .error-box {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-10">

                <div class="register-card">

                    <div class="text-center mb-4">
                        <div class="brand mb-1">
                            <i class="bi bi-person-plus"></i> Create Account
                        </div>
                        <p class="text-muted mb-0">Join us and start shopping</p>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger error-box">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="/register" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register w-100 text-white">
                            <i class="bi bi-check-circle me-1"></i> Register
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            Already have an account?
                            <a href="/login" class="text-primary fw-semibold">Login</a>
                        </small>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>

</html>