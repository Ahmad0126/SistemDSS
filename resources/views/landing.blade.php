<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="p-5">
        <h1 class="text-center">Explore Charts</h1>
        <div class="input-group pb-5">
            <input type="search" class="form-control" name="" id="" placeholder="Search Keyword">
            <button class="btn btn-primary">Search</button>
        </div>
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
                        {!! $g->image !!}
                    </div>
                    <div class="card-body">
                        <a href="{{ route('show_grafik', $g->id) }}">
                            <b>{{ $g->judul }}</b>
                        </a>
                        <p><small>{{ $g->nama }}</small></p>
                        
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-root>