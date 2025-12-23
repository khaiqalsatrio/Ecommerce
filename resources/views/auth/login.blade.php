<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="min-height:100vh">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center mb-4">Login</h4>

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        <form action="/login" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button class="btn btn-primary w-100">Login</button>
                        </form>

                        <div class="text-center mt-3">
                            <small>Belum punya akun?
                                <a href="/register">Register</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>