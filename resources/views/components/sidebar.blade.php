<div class="sidebar" data-background-color="white">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('base') }}" class="logo text-white">
                <h1 class="mb-0">SistemDSS</h1>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a href="{{ route('database') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Database</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#table">
                        <i class="fas fa-table"></i>
                        <p>Tabel</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="table">
                        <ul class="nav nav-collapse">
                            @foreach ($table as $t)
                                <li>
                                    <a href="{{ route('tabel', $t->id) }}">
                                        <span class="sub-item">{{ $t->nama }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>