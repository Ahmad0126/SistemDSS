<x-root :pointer="3">
    <x-slot:title>{{ $title }} </x-slot:title>
    <x-slot:sidebar>
        <x-sidebar :table="$tabel"></x-sidebar>
    </x-slot:sidebar>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">Tabel Anda</div>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_tabel"
                        data-url="{{ route('tambah_tabel') }}" data-judul="Tambah Tabel">
                        Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tabel</th>
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
                                            <a href="{{ route('struktur', $t->id) }}" class="btn btn-sm btn-warning">Struktur</a>
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-id="{{ $t->id }}"
                                                data-bs-target="#edit_tabel" data-nama="{{ $t->nama }}" data-judul="Edit Tabel"
                                                data-url="{{ route('edit_tabel') }}">
                                                Edit
                                            </button>
                                            <a href="{{ route('hapus_tabel', $t->id) }}" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus tabel ini?\r\nSemua data di dalamnya juga akan dihapus')">
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