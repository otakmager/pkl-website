<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('library/bootstrap-5.3/css/bootstrap.min.css') }}">
    <style>
        form i {
            margin-left: -30px;
            cursor: pointer;
        }
        body {
            background: #007bff;
            background: linear-gradient(to right, #0062e6, #33aeff);
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
        }

        #logo {
            border-radius: 80%;
            max-height: 70px;
        }
    </style>
    <title>Login</title>
</head>
<body>
    <!-- Login Page Start -->
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="logo mt-3 mb-3 d-flex justify-content-center">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" id="logo" />
                    </div>
                    <div class="card-body p-4 p-sm-4">
                        <h4 class="card-title text-center mb-4">Login</h4>
                        @if (session()->has('loginError'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('loginError') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif   
                        <form action="/login" method="POST">
                            @csrf
                            <div class="form-floating mb-2">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" autofocus required>
                                <label for="email">Email</label>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                <label for="password">Password</label>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>>@enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="#!" class="text-decoration-none mt-1 mb-4">Lupa password?</a>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Login</button>
                            </div>
                            <hr class="my-3" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Page End -->

    <!-- Script Start -->    
    <script src="{{ asset('library/bootstrap-5.3/js/bootstrap.min.js') }}"></script>
    <!-- Script End -->
</body>
</html>
