<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Daftar</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });

    </script>

    <style>
        body {
            display: flex;
            align-items: center;
            height: 100vh;
        }
    </style>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/kaiadmin.min.css') }}" />
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="card mt-5">
                    <div class="card-header">
                        <div class="card-title">Daftar</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            @if ($errors->any())
                                @foreach($errors->all() as $e)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $e }}
                                    </div>
                                @endforeach
                            @endif
                            <div class="basic-form">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input name="nama" type="text" class="form-control" placeholder="Masukkan Nama" value="{{ old('nama') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input name="email" type="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input name="password" type="password" class="form-control" placeholder="Buat Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Konfirmasi Password</label>
                                    <div class="col-sm-8">
                                        <input name="password_konfirmasi" type="password" class="form-control" placeholder="Masukkan Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    Sudah Punya Akun? <a href="{{ route('masuk') }}">Login</a>
                                </div>
                                <button class="btn btn-primary form-control mt-3">Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
