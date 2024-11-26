<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header p-0">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <h3 class="navbar-brand mb-0 ms-2">Data</h3>
                        <ul class="navbar-nav flex-row me-auto mb-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Tambah
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_kolom"
                                            data-url="{{ route('tambah_kolom') }}" data-judul="Tambah Kolom" data-id="{{ $table['tabel']->id }}">
                                            Kolom
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#tambah_baris">
                                            Baris
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Hapus
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#hapus_kolom">Kolom</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#hapus_baris">Baris</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered-bd-black table-head-bg-dark">
                        <thead>
                            <tr>
                                <th style="background: #ced4da">#</th>
                                @foreach ($table['kolom'] as $k)
                                    <th style="background: #ced4da; cursor: pointer;" data-bs-toggle="modal" data-id="{{ $k->id }}"
                                        data-bs-target="#edit_kolom" data-nama="{{ $k->nama }}" data-urutan="{{ $k->urutan }}"
                                        data-url="{{ route('edit_kolom') }}" data-judul="Edit Kolom">
                                        {{ $k->nama }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($table['kolom']) == 0)
                                <tr>
                                    <td colspan="2">Belum ada data. Tambahkan kolom terlebih dahulu</td>
                                </tr>
                            @elseif (count($table['baris']) == 0)
                                <tr>
                                    <td colspan="{{ count($table['kolom']) + 2 }}">Belum ada data</td>
                                </tr>
                            @endif
                            @php $no = 1; @endphp
                            @foreach ($table['baris'] as $r)
                                <tr>
                                    <th scope="row" class="baris c-pointer" data-id="{{ $r->id }}" data-urutan="{{ $r->urutan }}" style="width: 30px; background: #ced4da">{{ $no++ }}</th>
                                    @foreach ($table['kolom'] as $k)
                                        <td class="c-pointer data" data-id_kolom="{{ $k->id }}" data-id_baris="{{ $r->id }}">{{ $table['data'][$r->id][$k->nama] ?? '' }}</td>
                                    @endforeach
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
                <h1 class="modal-title fs-5">Tambah Kolom</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambah_data') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="">Nama Kolom</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Kolom">
                    </div>
                    <div class="form-group">
                        <label for="">Urutan</label>
                        <select name="urutan" id="" class="form-control form-select">
                            @php $nama = 'Pertama'; @endphp
                            @foreach ($table['kolom'] as $k)
                                <option value="{{ $k->urutan }}">{{ $nama }}</option>
                                @php $nama = 'Setelah '.$k->nama; @endphp
                            @endforeach
                            <option value="" selected>Terakhir</option>
                        </select>
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
<div class="modal fade" id="tambah_baris">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Baris</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambah_baris') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" value="{{ $table['tabel']->id }}">
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah Baris">
                    </div>
                    <div class="form-group">
                        <label for="">Sisipkan ke</label>
                        <input type="number" name="urutan" class="form-control" placeholder="Urutan Baris">
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
<div class="modal fade" id="edit_data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit_data') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id_kolom">
                    <input type="hidden" name="id_baris">
                    <div class="form-group">
                        <label for="">Data</label>
                        <input type="text" name="data" placeholder="Data" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus_kolom">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Hapus Kolom</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('hapus_kolom') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Pilih Kolom</label>
                        <div class="input-group">
                            <select name="id" id="" class="form-control form-select">
                                @foreach ($table['kolom'] as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @php $nama = 'Setelah '.$k->nama; @endphp
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus kolom ini?\r\nData dalam kolom ini juga akan dihapus')">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus_baris">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Hapus Baris</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('hapus_baris') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" value="{{ $table['tabel']->id }}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Dari Baris</label>
                                <select name="from" id="" class="form-control form-select">
                                    @php $no = 1; @endphp
                                    @foreach ($table['baris'] as $b)
                                        <option value="{{ $b->urutan }}">{{ $no++ }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Sampai Baris</label>
                                <select name="to" id="" class="form-control form-select">
                                    <option value="">...</option>
                                    @php $no = 1; @endphp
                                    @foreach ($table['baris'] as $b)
                                        <option value="{{ $b->urutan }}">{{ $no++ }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Yakin ingin menghapus baris ini?\r\nData dalam baris ini juga akan dihapus')">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_baris">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Hapus Baris</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('edit_baris') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" value="{{ $table['tabel']->id }}">
                    <div class="form-group">
                        <label for="">Pindahkan urutan baris</label>
                        <div class="input-group">
                            <input type="hidden" name="id">
                            <select name="urutan" id="" class="form-control form-select">
                                @php $no = 1; $nama = 'Pertama'; @endphp
                                @foreach ($table['baris'] as $b)
                                    <option value="{{ $b->urutan }}">{{ $nama }}</option>
                                    @php $nama = 'Setelah baris ke '.$no++; @endphp
                                @endforeach
                                <option value="" selected>Terakhir</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Pindahkan</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('hapus_baris') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $table['tabel']->id }}">
                    <button type="submit" class="btn btn-danger" name="from"
                        onclick="return confirm('Yakin ingin menghapus baris ini?\r\nData dalam baris ini juga akan dihapus')">
                        Hapus
                    </button>
                </form>
            </div>
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
        modal.find('select[name="urutan"]').val(button.data('urutan'));
        modal.find('input[name="id"]').val(id);
        modal.find('input[name="nama"]').val(nama);
    });
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
    $('.data').on('click', function(event){
        var modal = $('#edit_data')
        modal.find('input[name="data"]').val($(this).html())
        modal.find('input[name="id_kolom"]').val($(this).data('id_kolom'))
        modal.find('input[name="id_baris"]').val($(this).data('id_baris'))
        modal.modal('show')
    })
    $('.baris').on('click', function(event){
        var modal = $('#edit_baris')
        modal.find('input[name="id"]').val($(this).data('id'))
        modal.find('button[name="from"]').val($(this).data('urutan'))
        modal.modal('show')
    })
</script>