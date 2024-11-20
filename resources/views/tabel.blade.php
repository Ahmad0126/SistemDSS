<x-root>
    <style>
        td, th{
            padding: 0.3rem 0.5rem !important;
        }
        .c-pointer{
            cursor: pointer;
        }
    </style>
    <x-slot:title>{{ $title }} </x-slot:title>
    <x-slot:menu>
        <li class="nav-item active">
            <a href="{{ route('tabel', $table['tabel']->id) }}">
                <i class="fas fa-layer-group"></i>
                <p>Data</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('struktur', $table['tabel']->id) }}">
                <i class="fas fa-th-list"></i>
                <p>Struktur Tabel</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('grafik', $table['tabel']->id) }}">
                <i class="far fa-chart-bar"></i>
                <p>Grafik</p>
            </a>
        </li>
    </x-slot:menu>

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Tabel {{ $table['tabel']->nama }}</h3>
            {{-- <h6 class="op-7 mb-2">Free Bootstrap 5 Admin Dashboard</h6> --}}
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
            <a href="#" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#edit_data"
                data-url="{{ route('tambah_data') }}" data-judul="Tambah Data" data-id="{{ $table['tabel']->id }}">
                Tambah Data
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data dalam tabel</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered-bd-black table-head-bg-dark">
                            <thead>
                                <tr>
                                    <th style="background: #ced4da">#</th>
                                    @foreach ($table['kolom'] as $k)
                                        <th style="background: #ced4da">{{ $k->nama }}</th>
                                    @endforeach
                                    <th style="background: #ced4da">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($table['kolom']) == 0)
                                    <tr>
                                        <td>Belum ada data. Tambahkan kolom terlebih dahulu</td>
                                    </tr>
                                @elseif (count($table['baris']) == 0)
                                    <tr>
                                        <td colspan="{{ count($table['kolom']) + 1 }}">Belum ada data</td>
                                    </tr>
                                @endif
                                @php $no = 1; @endphp
                                @foreach ($table['baris'] as $r)
                                    <tr>
                                        <th scope="row" style="width: 30px; background: #ced4da">{{ $no++ }}</th>
                                        @foreach ($table['kolom'] as $k)
                                            <td class="c-pointer">{{ $table['data'][$r->id][$k->nama] ?? '' }}</td>
                                        @endforeach
                                        <td style="width: 60px; background: #ced4da">
                                            <button class="btn p-1 btn-link btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_data"
                                                data-url="{{ route('edit_data') }}" data-judul="Edit Data" data-id="{{ $r->id }}"
                                                @foreach ($table['kolom'] as $k)
                                                    data-{{ $k->id }}="{{ $table['data'][$r->id][$k->nama] ?? '' }}"
                                                @endforeach>
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a href="{{ route('hapus_data', $r->id) }}" class="btn btn-link p-1 btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fa fa-times"></i>
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
    <div class="modal fade" id="edit_data">
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
                        @foreach ($table['kolom'] as $k)
                            <div class="form-group">
                                <label for="">{{ $k->nama }} </label>
                                <input type="text" name="{{ $k->id }}"
                                    placeholder="{{ $k->nama }}" class="form-control">
                            </div>
                        @endforeach
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
        $('#edit_data').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('form').attr('action', button.data('url'));
            modal.find('h1.modal-title').html(button.data('judul'));
            modal.find('button[type="submit"]').html(button.data('judul'));
            modal.find('input[name="id"]').val(id);
            @foreach ($table['kolom'] as $k)
                modal.find('input[name="{{ $k->id }}"]').val(button.data('{{ $k->id }}'));
            @endforeach
        });
    </script>
</x-root>
