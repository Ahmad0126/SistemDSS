<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>
    <x-slot:menu>
        <li class="nav-item">
            <a href="{{ route('tabel', $tabel->id) }}">
                <i class="fas fa-layer-group"></i>
                <p>Data</p>
            </a>
        </li>
        <li class="nav-item active">
            <a href="{{ route('struktur', $tabel->id) }}">
                <i class="fas fa-th-list"></i>
                <p>Struktur Tabel</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('grafik', $tabel->id) }}">
                <i class="far fa-chart-bar"></i>
                <p>Grafik</p>
            </a>
        </li>
    </x-slot:menu>

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Struktur Tabel {{ $tabel->nama }}</h3>
            {{-- <h6 class="op-7 mb-2">Free Bootstrap 5 Admin Dashboard</h6> --}}
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
            <a href="#" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#edit_kolom"
                data-url="{{ route('tambah_kolom') }}" data-judul="Tambah Kolom" data-id="{{ $tabel->id }}">
                Tambah Kolom
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kolom dalam tabel</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kolom</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($kolom as $k)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        <td>{{ $k->nama }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-id="{{ $k->id }}"
                                                data-bs-target="#edit_kolom" data-nama="{{ $k->nama }}"
                                                data-url="{{ route('edit_kolom') }}" data-judul="Edit Kolom">
                                                Edit
                                            </button>
                                            <a href="{{ route('hapus_kolom', $k->id) }}" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus kolom ini?\r\nData dalam kolom ini juga akan dihapus')">
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
    <div class="modal fade" id="edit_kolom">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah_data') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Kolom">
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
        $('#edit_kolom').on('show.bs.modal', function(event){
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
