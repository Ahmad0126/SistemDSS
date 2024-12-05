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
                            <textarea id="query" name="query" class="form-control" rows="3" placeholder="Masukkan Query Anda">{{ session('query') }} </textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Jalankan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-data-table :baris="$baris" :kolom="$kolom"></x-data-table>
</x-root>
