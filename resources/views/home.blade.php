<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>
    <x-slot:menu>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#base">
                <i class="fas fa-layer-group"></i>
                <p>Base</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="base">
                <ul class="nav nav-collapse">
                    <li>
                        <a href="components/avatars.html">
                            <span class="sub-item">Avatars</span>
                        </a>
                    </li>
                    <li>
                        <a href="components/buttons.html">
                            <span class="sub-item">Buttons</span>
                        </a>
                    </li>
                    <li>
                        <a href="components/gridsystem.html">
                            <span class="sub-item">Grid System</span>
                        </a>
                    </li>
                    <li>
                        <a href="components/panels.html">
                            <span class="sub-item">Panels</span>
                        </a>
                    </li>
                    <li>
                        <a href="components/notifications.html">
                            <span class="sub-item">Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a href="components/sweetalert.html">
                            <span class="sub-item">Sweet Alert</span>
                        </a>
                    </li>
                    <li>
                        <a href="components/font-awesome-icons.html">
                            <span class="sub-item">Font Awesome Icons</span>
                        </a>
                    </li>
                    <li>
                        <a href="components/simple-line-icons.html">
                            <span class="sub-item">Simple Line Icons</span>
                        </a>
                    </li>
                    <li>
                        <a href="components/typography.html">
                            <span class="sub-item">Typography</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts">
                <i class="fas fa-th-list"></i>
                <p>Sidebar Layouts</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="sidebarLayouts">
                <ul class="nav nav-collapse">
                    <li>
                        <a href="sidebar-style-2.html">
                            <span class="sub-item">Sidebar Style 2</span>
                        </a>
                    </li>
                    <li>
                        <a href="icon-menu.html">
                            <span class="sub-item">Icon Menu</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#forms">
                <i class="fas fa-pen-square"></i>
                <p>Forms</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="forms">
                <ul class="nav nav-collapse">
                    <li>
                        <a href="forms/forms.html">
                            <span class="sub-item">Basic Form</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#tables">
                <i class="fas fa-table"></i>
                <p>Tables</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav nav-collapse">
                    <li>
                        <a href="tables/tables.html">
                            <span class="sub-item">Basic Table</span>
                        </a>
                    </li>
                    <li>
                        <a href="tables/datatables.html">
                            <span class="sub-item">Datatables</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#maps">
                <i class="fas fa-map-marker-alt"></i>
                <p>Maps</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="maps">
                <ul class="nav nav-collapse">
                    <li>
                        <a href="maps/googlemaps.html">
                            <span class="sub-item">Google Maps</span>
                        </a>
                    </li>
                    <li>
                        <a href="maps/jsvectormap.html">
                            <span class="sub-item">Jsvectormap</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#charts">
                <i class="far fa-chart-bar"></i>
                <p>Charts</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav nav-collapse">
                    <li>
                        <a href="charts/charts.html">
                            <span class="sub-item">Chart Js</span>
                        </a>
                    </li>
                    <li>
                        <a href="charts/sparkline.html">
                            <span class="sub-item">Sparkline</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a href="widgets.html">
                <i class="fas fa-desktop"></i>
                <p>Widgets</p>
                <span class="badge badge-success">4</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="../../documentation/index.html">
                <i class="fas fa-file"></i>
                <p>Documentation</p>
                <span class="badge badge-secondary">1</span>
            </a>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#submenu">
                <i class="fas fa-bars"></i>
                <p>Menu Levels</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="submenu">
                <ul class="nav nav-collapse">
                    <li>
                        <a data-bs-toggle="collapse" href="#subnav1">
                            <span class="sub-item">Level 1</span>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="subnav1">
                            <ul class="nav nav-collapse subnav">
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Level 2</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Level 2</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="collapse" href="#subnav2">
                            <span class="sub-item">Level 1</span>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="subnav2">
                            <ul class="nav nav-collapse subnav">
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Level 2</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#">
                            <span class="sub-item">Level 1</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </x-slot:menu>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">Tabel Anda</div>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_tabel"
                        data-url="{{ route('tambah_tabel') }}" data-judul="Tambah tabel">
                        Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Tabel</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($tabel as $t)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        <td>{{ $t->nama }}</td>
                                        <td>
                                            <a href="{{ route('tabel', $t->id) }}" class="btn btn-sm btn-info">Buka</a>
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-id="{{ $t->id }}"
                                                data-bs-target="#edit_tabel" data-nama="{{ $t->nama }}" data-judul="Edit tabel"
                                                data-url="{{ route('edit_tabel') }}">
                                                Edit
                                            </button>
                                            <a href="{{ route('hapus_tabel', $t->id) }}" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus tabel ini?\r\nData dalam tabel ini juga akan dihapus')">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_tabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Tabel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah_tabel') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Tabel">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#edit_tabel').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var nama = button.data('nama');
            var id = button.data('id');
            var modal = $(this);
            modal.find('form').attr('action', button.data('url'));
            modal.find('h1.modal-title').html(button.data('judul'));
            modal.find('button[type="submit"]').html(button.data('judul'));
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="nama"]').val(nama);
        });
    </script>
</x-root>