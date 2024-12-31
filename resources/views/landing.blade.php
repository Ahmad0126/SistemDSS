<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="p-5">
        <h1 class="text-center">Explore {{ $public ? 'Charts' : 'Projects' }}</h1>
        <form action="{{ $public ? route('search') : route('search_mine') }}" method="get" id="search">
            <div class="input-group pb-5">
                <input type="search" class="form-control" name="key" id="" placeholder="Search Keyword" @if ($public) value="{{ $old['key'] }}" @endif>
                @if ($public)
                    <input type="hidden" name="publisher" value="{{ $old['publisher'] }}">
                    <input type="hidden" name="tipe_grafik" value="{{ $old['tipe_grafik'] }}">
                    <input type="hidden" name="order_by" value="{{ $old['order_by'] }}">
                    <input type="hidden" name="urutan" value="{{ $old['urutan'] }}">
                @endif
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <p>Menampilkan data {{ $grafik->firstItem()."-".$grafik->lastItem() }} dari {{ $grafik->total() }}</p>
        </div>
        @if ($public)
            <div class="col-sm-6">
                <div class="d-flex justify-content-end gap-3">
                    <a class="text-dark" href="#" data-bs-toggle="modal" data-bs-target="#urutkan">
                        <p>Urutkan <i class="fas fa-sort-amount-up"></i></p>
                    </a>
                    <a class="text-dark" href="#" data-bs-toggle="modal" data-bs-target="#filter">
                        <p>Filter <i class="fa fa-filter"></i></p>
                    </a>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <style>
            svg{
                height: 100%;
                width: 100%;
            }
        </style>
        @foreach ($grafik as $g)
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card">
                    <div class="card-img-top p-2 pb-0">
                        <img title="{{ $g->judul }}" src="{{ route('thumbnail_grafik', $g->id) }}" class="img-fluid" alt="{{ $g->judul }}">
                    </div>
                    <div class="card-body">
                        <a href="{{ route('project', $g->id) }}">
                            <b>{{ $g->judul }}</b>
                        </a>
                        <p><small>{{ $g->nama }}</small></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $grafik->onEachSide(1)->links('pagination.template') }}
    </div>
    @if ($public)
        <div class="modal fade" id="filter">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Filter</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Publisher</label>
                            <input type="text" id="publisher" class="form-control" placeholder="Nama Publisher" value="{{ $old['publisher'] }}">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Grafik</label>
                            <select id="tipe_grafik" class="form-control form-select">
                                <option value="">-</option>
                                <option @selected($old['tipe_grafik'] == 'bar') value="bar">Bar</option>
                                <option @selected($old['tipe_grafik'] == 'line') value="line">Line</option>
                                <option @selected($old['tipe_grafik'] == 'pie') value="pie">Pie</option>
                                <option @selected($old['tipe_grafik'] == 'scatter') value="scatter">Scatter</option>
                                <option @selected($old['tipe_grafik'] == 'radar') value="radar">Radar</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary batal-filter" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="terapkan">Terapkan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="urutkan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Urutkan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Urut Berdasarkan</label>
                            <select id="order_by" class="form-control form-select">
                                <option @selected($old['order_by'] == 'tanggal') value="tanggal">Tanggal Dibuat</option>
                                <option @selected($old['order_by'] == 'judul') value="judul">Judul</option>
                                <option @selected($old['order_by'] == 'nama') value="nama">Nama Publisher</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Urutan</label>
                            <select id="urutan" class="form-control form-select">
                                <option @selected($old['urutan'] == 'asc') value="asc">Ke Atas</option>
                                <option @selected($old['urutan'] == 'desc') value="desc">Ke Bawah</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary batal-urutkan" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="sort">Urutkan</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const form = $('#search');

            $('#sort').click(function(){
                form.find('input[name="order_by"]').val($('#order_by').val());
                form.find('input[name="urutan"]').val($('#urutan').val());

                form.submit();
            });
            $('#terapkan').click(function(){
                form.find('input[name="publisher"]').val($('#publisher').val());
                form.find('input[name="tipe_grafik"]').val($('#tipe_grafik').val());

                form.submit();
            });
            $('.batal-filter').click(function(){
                form.find('input[name="publisher"]').val('');
                form.find('input[name="tipe_grafik"]').val('');;
            });
            $('.batal-urutkan').click(function(){;
                form.find('input[name="order_by"]').val('');
                form.find('input[name="urutan"]').val('');
            })
        </script>
    @endif
</x-root>