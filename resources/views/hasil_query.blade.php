<x-root>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:sidebar>
        <x-sidebar :table="$tabel"></x-sidebar>
    </x-slot:sidebar>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('run_query') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea id="query" name="query" class="form-control" rows="3" placeholder="Masukkan Query Anda">{{ session('query') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Jalankan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('query_error') || session('alert'))
        <div class="row">
            <div class="col">
                @if (session('query_error'))
                    <div class="alert alert-danger">
                        {{ session('query_error') }}
                    </div>
                @else
                    <div class="alert alert-success">
                        {{ session('alert') }}
                    </div>
                @endif
            </div>
        </div>
    @endif
    @if (isset($kolom) && isset($baris))
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">Hasil Query</div>
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#buat_grafik">Buat Gafik</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <x-data-table :baris="$baris" :kolom="$kolom"></x-data-table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="buat_grafik">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Buat Grafik</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('tambah_grafik') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="query" value="{{ session('query') }}">
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
                            <button type="submit" class="btn btn-primary">Buat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-root>
