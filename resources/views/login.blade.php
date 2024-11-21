<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
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
                        <div class="card-title">Silahkan Login</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            @if ($errors->any())
                                @foreach($errors->all() as $e)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $e }}
                                    </div>
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label for="email2">Email</label>
                                <input name="email" type="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}"/>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                Belum Punya Akun? <a href="{{ route('daftar') }}">Daftar</a>
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-primary form-control" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
