<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="p-5">
        <h1 class="text-center">Explore {{ $public ? 'Charts' : 'Projects' }}</h1>
        <form action="{{ $public ? route('search') : route('search_mine') }}" method="get">
            <div class="input-group pb-5">
                <input type="search" class="form-control" name="key" id="" placeholder="Search Keyword">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>

    <p>Menampilkan data {{ $grafik->firstItem()."-".$grafik->lastItem() }} dari {{ $grafik->total() }}</p>
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
                        {!! $g->image !!}
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
</x-root>