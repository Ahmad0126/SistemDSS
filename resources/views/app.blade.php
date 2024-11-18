<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
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
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <!--   Core JS Files   -->
    <script src="{{ Vite::asset('resources/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/core/popper.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ Vite::asset('resources/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ Vite::asset('resources/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ Vite::asset('resources/js/kaiadmin.min.js') }}"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/kaiadmin.min.css') }}" />

    @viteReactRefresh
    @vite('resources/js/app.jsx')
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
