<x-root>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    @foreach ($kolom as $kol)
                                        <th>{{ $kol }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($baris as $row)
                                    <tr>
                                        @foreach ($kolom as $kol)
                                            <td>{{ $row[$kol] }}</td>
                                        @endforeach
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