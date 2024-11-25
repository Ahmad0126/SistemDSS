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
        <div class="main-panel w-100">
            <div class="main-header w-100" data-background-color="dark">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <div class="nav-toggle">
                            <button class="btn btn-toggle topbar-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" data-background-color="dark">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav align-items-center w-100">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('base') }}">Home</a>
                            </li>
                            @can('admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user') }}">User</a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link" href="#">Project</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Template</a>
                            </li>
                            <li class="nav-item topbar-user dropdown hidden-caret ms-md-auto">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="public/assets/img/profile.jpg" alt="..."
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
                                                    <img src="public/assets/img/profile.jpg" alt="image profile"
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
                                            <a href="profile.html" class="dropdown-item">
                                                View Profile
                                            </a>
                                            <form action="{{ route('logout') }}" method="post">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>
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
                    delay: 3000,
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
