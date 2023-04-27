<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('library/bootstrap-5.3/css/bootstrap.min.css') }}">    
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
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
    <title>Lupa Password</title>
</head>
<body>
    <!-- Lupa Password Page Start -->
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="logo mt-3 mb-3 d-flex justify-content-center">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" id="logo" />
                    </div>
                    <div class="card-body p-4 p-sm-4">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-lupa" hidden>
                            <div id="isi-lupa"></div>
                        </div>
                        <form id="form-pass">
                            @csrf
                            <h6 class="text-center mt-2">Masukkan email Anda!</h6>
                            <div class="form-floating mb-4">
                                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" autofocus required>
                                <label for="email">Email</label>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Cek Email</button>
                            </div>
                            <hr class="my-3"/>                            
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('login') }}" class="text-decoration-none mt-1 mb-4">Login?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    @include('forgetPassword.modal.opsi-recov')
    @include('forgetPassword.modal.soal')
    @include('forgetPassword.modal.reset-pass')
    <!-- Lupa Password Page End -->

    <!-- Script Start -->    
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-5.3/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/auth/forget.js') }}"></script>
    <!-- Script End -->
</body>
</html>
