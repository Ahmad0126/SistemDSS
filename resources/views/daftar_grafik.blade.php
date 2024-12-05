<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">Grafik Anda</div>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_grafik"
                        data-url="{{ route('tambah_grafik') }}" data-title="Tambah Grafik">
                        Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Grafik</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($grafik as $t)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        <td>{{ $t->judul }}</td>
                                        <td>{{ $t->tipe }}</td>
                                        <td>
                                            <a href="{{ route('grafik', $t->id) }}" class="btn btn-sm btn-info">Buka</a>
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-id="{{ $t->id }}"
                                                data-bs-target="#edit_grafik" data-judul="{{ $t->judul }}" data-title="Edit Grafik"
                                                data-url="{{ route('edit_grafik') }}" data-tipe="{{ $t->tipe }}">
                                                Edit
                                            </button>
                                            <a href="{{ route('hapus_grafik', $t->id) }}" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus grafik ini?\r\nSemua data di dalamnya juga akan dihapus')">
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
    <div class="modal fade" id="edit_grafik">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Grafik</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah_grafik') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="">Judul</label>
                            <input type="text" name="judul" class="form-control" placeholder="Judul Grafik">
                        </div>
                        <div class="form-group">
                            <label for="">Tipe</label>
                            <select name="tipe" id="" class="form-control form-select">
                                <option value="bar">bar</option>
                                <option value="line">line</option>
                                <option value="scatter">scatter</option>
                                <option value="pie">pie</option>
                                <option value="radar">radar</option>
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
    <script>
        $('#edit_grafik').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var judul = button.data('judul');
            var id = button.data('id');
            var modal = $(this);
            modal.find('form').attr('action', button.data('url'));
            modal.find('h1.modal-title').html(button.data('title'));
            modal.find('button[type="submit"]').html(button.data('title'));
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="judul"]').val(judul);
            modal.find('input[select="tipe"]').val(button.data('tipe'));
        });
    </script>
</x-root>