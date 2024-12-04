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

    @if (isset($kolom) && isset($baris))
        <style>
            td, th {
                padding: 0.3rem 0.5rem !important;
            }
            .c-pointer {
                cursor: pointer;
            }
        </style>
        <div class="row">
            <div class="col">
                <h1>Hasil Query</h1>
                @if (count($baris) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered-bd-black table-head-bg-dark">
                            <thead>
                                <tr>
                                    @foreach ($kolom as $column)
                                        <th style="background: #ced4da">{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($baris as $row)
                                    <tr>
                                        @foreach ($kolom as $column)
                                            <td>{{ $row[$column] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">No results found for your query.</div>
                @endif
            </div>
        </div>
    @endif
</x-root>
