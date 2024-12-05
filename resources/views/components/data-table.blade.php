@if (isset($kolom) && isset($baris))
    <style>
        td,
        th {
            padding: 0.3rem 0.5rem !important;
        }

        .c-pointer {
            cursor: pointer;
        }
    </style>
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
        <div class="alert alert-info">Tidak ada data yang dihasilkan</div>
    @endif
@endif
