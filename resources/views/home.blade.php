<x-root :pointer="1">
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="p-3">
        <h1 class="text-center">Explore Projects</h1>
        <div class="input-group pb-3">
            <input type="search" class="form-control" name="" id="" placeholder="Search Keyword">
            <button class="btn btn-primary">Search</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Published Project</h2>
            <div class="row">
                <style>
                    svg{
                        height: 100%;
                        width: 100%;
                    }
                </style>
                @foreach ($published as $g)
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-img-top p-2 pb-0">
                                {!! $g->image !!}
                            </div>
                            <div class="card-body">
                                <b>{{ $g->judul }}</b>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <h2>Grafik Terbaru</h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Grafik</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($grafik as $t)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        <td>{{ $t->judul }}</td>
                                        <td>
                                            <a href="{{ route('grafik', $t->id) }}" class="btn btn-sm btn-info">Buka</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tabel Terbaru</div>
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