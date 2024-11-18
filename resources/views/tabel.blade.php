<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tambahkan Kolom</div>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tabel {{ $table['tabel']->nama }}</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @foreach ($table['kolom'] as $k)
                                        <th>{{ $k->nama }}</th>
                                    @endforeach
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($table['baris'] as $r)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        @foreach ($table['kolom'] as $k)
                                            <td>{{ $table['data'][$r->id][$k->nama] ?? '' }}</td>
                                        @endforeach
                                        <td>
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_jalan">
                                                Edit
                                            </button>
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
</x-root>