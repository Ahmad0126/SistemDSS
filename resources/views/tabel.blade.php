<x-root>
    <style>
        td, th{
            padding: 0.3rem 0.5rem !important;
        }
        .c-pointer{
            cursor: pointer;
        }
    </style>
    <x-slot:title>{{ $title }} </x-slot:title>
    <x-slot:sidebar>
        <x-sidebar :table="$tabel" :pointer="$id"></x-sidebar>
    </x-slot:sidebar>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="d-md-flex justify-content-between align-items-center">
                        <div class="card-title">Data dalam tabel</div>
                        <p>Menampilkan data {{ $page->firstItem().' - '.$page->lastItem()  }} dari {{ $page->total() }}</p>
                    </div>
                </div>
                <div class="card-body">
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
                        <div class="alert alert-info">Belum ada data di tabel ini</div>
                    @endif
                    {{ $page->onEachSide(1)->links('pagination.template') }}
                </div>
            </div>
        </div>
    </div>
</x-root>
