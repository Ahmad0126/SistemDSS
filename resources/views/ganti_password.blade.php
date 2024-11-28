<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Ganti Password</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ Vite::asset('resources/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ Vite::asset('resources/js/plugin/webfont/webfont.min.js') }}"></script>
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
                urls: ["{{ Vite::asset('resources/css/fonts.min.css') }}"],
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
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/kaiadmin.min.css') }}" />
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Ganti Password</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ganti_password') }}" method="post">
                            @csrf
                            @if ($errors->any())
                                @foreach($errors->all() as $e)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $e }}
                                    </div>
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label>Password Lama</label>
                                <input name="password_lama" value="{{ old('password_lama') }}" type="password" class="form-control" placeholder="Masukkan Password"/>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input name="password_baru" value="{{ old('password_baru') }}" type="password" class="form-control" placeholder="Buat Password"/>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input name="password_konfirmasi" value="{{ old('password_konfirmasi') }}" type="password" class="form-control" placeholder="Konfirmasi Password"/>
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-primary form-control" type="submit">Ganti</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
