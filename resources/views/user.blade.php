<x-root :pointer="2">
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">Daftar User</div>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_user"
                        data-url="{{ route('tambah_user') }}" data-judul="Tambah user">
                        Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($user as $t)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        <td>{{ $t->nama }}</td>
                                        <td>{{ $t->email }}</td>
                                        <td>{{ $t->level }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-id="{{ $t->id }}"
                                                data-bs-target="#edit_user" data-nama="{{ $t->nama }}" data-judul="Edit user"
                                                data-url="{{ route('edit_user') }}" data-email="{{ $t->email }}" 
                                                data-level="{{ $t->level }}" data-edit="true">
                                                Edit
                                            </button>
                                            @if (Auth::user()->id != $t->id)
                                                <a href="{{ route('hapus_user', $t->id) }}" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                    Hapus
                                                </a>
                                            @endif
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
    <div class="modal fade" id="edit_user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah_user') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group" id="password">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="">Level</label>
                            <select name="level" id="" class="form-control form-select">
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
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
        $('#edit_user').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var nama = button.data('nama');
            var id = button.data('id');
            var modal = $(this);
            modal.find('#password').show();
            if(button.data('edit')){
                modal.find('#password').hide();
            }
            modal.find('form').attr('action', button.data('url'));
            modal.find('h1.modal-title').html(button.data('judul'));
            modal.find('button[type="submit"]').html(button.data('judul'));
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="nama"]').val(nama);
            modal.find('input[name="email"]').val(button.data('email'));
            modal.find('select[name="level"]').val(button.data('level'));
        });
    </script>
</x-root>