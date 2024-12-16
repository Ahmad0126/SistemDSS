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
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/kaiadmin.css') }}" />

    <title>{{ $title }} </title>
</head>

<body>
    <div class="wrapper">
        {{ $sidebar ?? '' }}
        <div class="main-panel {{ isset($sidebar) ? '' : 'w-100' }}">
            <div class="main-header {{ isset($sidebar) ? '' : 'w-100' }}" data-background-color="dark">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ route('home') }}" class="logo text-white">
                            <h1 class="mb-0">SistemDSS</h1>
                        </a>
                        <div class="nav-toggle">
                            @isset($sidebar) 
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                            @endisset
                        </div>
                        <button class="topbar-toggler more">
                            <i class="{{ isset($sidebar) ? 'gg-more-vertical-alt' : 'gg-menu-right' }}"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" data-background-color="dark">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav align-items-center w-100">
                            @auth
                                <li class="nav-item {{ $pointer == 1 ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('base') }}">Home</a>
                                </li>
                                @can('admin')
                                    <li class="nav-item {{ $pointer == 2 ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('user') }}">User</a>
                                    </li>
                                @endcan
                                <li class="nav-item {{ $pointer == 3 ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('database') }}">Database</a>
                                </li>
                                <li class="nav-item {{ $pointer == 4 ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('query') }}">Query</a>
                                </li>
                                <li class="nav-item {{ $pointer == 5 ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('daftar_grafik') }}">Grafik</a>
                                </li>
                                <li class="nav-item topbar-user dropdown hidden-caret ms-md-auto">
                                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                        aria-expanded="false">
                                        <div class="avatar-sm">
                                            <img src="{{ Vite::asset('resources/img/unknown.png') }}" alt="..."
                                                class="avatar-img rounded-circle" />
                                        </div>
                                        <span class="profile-username">
                                            <span class="fw-bold">{{ Auth::user()->nama }}</span>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                                        <div class="dropdown-user-scroll scrollbar-outer">
                                            <li>
                                                <div class="user-box">
                                                    <div class="avatar-lg">
                                                        <img src="{{ Vite::asset('resources/img/unknown.png') }}" alt="image profile"
                                                            class="avatar-img rounded" />
                                                    </div>
                                                    <div class="u-text text-white">
                                                        <h4>{{ Auth::user()->nama }}</h4>
                                                        <small class="op-7">{{ Auth::user()->email }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider"></div>
                                                <a href="{{ route('change_password') }}" class="dropdown-item">
                                                Ganti Password
                                                </a>
                                                <form action="{{ route('logout') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">Logout</button>
                                                </form>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                            @endauth
                            @guest
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="logo text-white">
                                        <h1 class="mb-0">SistemDSS</h1>
                                    </a>
                                </li>
                                <li class="nav-item ms-md-auto">
                                    <a class="nav-link" href="{{ route('daftar') }}">Daftar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
            <div class="container">
                <div class="page-inner">
                    {{ $slot }}
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid d-flex justify-content-center">
                    <div class="copyright">
                        &copy; 2024, 
                        <a href="https://github.com/Ahmad0126" target="_blank">Ahmad Zaid.</a> 
                        All Rights Reserved
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $e)
                $.notify({
                    title: 'FAILED',
                    message: '{{ $e }}',
                    icon: 'fas fa-exclamation-triangle',
                }, {
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right',
                    },
                    time: 1000,
                    delay: 6000,
                });
            @endforeach
        @endif
        @if ($notif = Session::get('alert'))
            $.notify({
                title: 'OK',
                message: '{{ $notif }}',
                icon: 'fas fa-check',
            }, {
                type: 'success',
                placement: {
                    from: 'top',
                    align: 'right',
                },
                time: 1000,
                delay: 3000,
            });
        @endif
    </script>
</body>

</html>
