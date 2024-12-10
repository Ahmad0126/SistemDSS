<x-root :pointer="4">
    <x-slot:title>{{ $title }} </x-slot:title>
    <x-slot:sidebar>
        <x-sidebar :table="$tabel"></x-sidebar>
    </x-slot:sidebar>

    <h1>Input Query</h1>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('run_query') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="query" id="" cols="30" rows="10" class="form-control" placeholder="Masukkan Query Anda">{{ old('query') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Jalankan
                            </button>
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
</x-root>