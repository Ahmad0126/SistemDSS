<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>
    <x-slot:sidebar>
        <x-sidebar :table="$tabel"></x-sidebar>
    </x-slot:sidebar>
    
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
                                    <th>Tipe Data</th>
                                    <th>Boleh Kosong</th>
                                    <th>Key</th>
                                    <th>Nilai Default</th>
                                    <th>Ekstra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($kolom as $k)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        <td>{{ $k->Field }}</td>
                                        <td>{{ $k->Type }}</td>
                                        <td>{{ $k->Null }}</td>
                                        <td>{{ $k->Key }}</td>
                                        <td>{{ $k->Default }}</td>
                                        <td>{{ $k->Extra }}</td>
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
