<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $title }}</div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 400px" id="barChart"></div>
                </div>
            </div>
        </div>
        <style>
            td,
            th {
                padding: 0.3rem 0.5rem !important;
            }

            .c-pointer {
                cursor: pointer;
            }
        </style>
        <div class="col-md-4">
            <div class="card">
                <form action="{{ route('simpan_grafik') }}" method="post">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title">Pengaturan</div>
                        <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
                    </div>
                    <div class="card-body" style="height: 435px; overflow-y: scroll">
                        @csrf
                        <div class="form-group">
                            <label for="">Tipe Grafik</label>
                            <select name="tipe" id="" class="form-control form-select">
                                <option @selected($table['tabel']->tipe == 'bar') value="bar">Bar</option>
                                <option @selected($table['tabel']->tipe == 'line') value="line">Line</option>
                                <option @selected($table['tabel']->tipe == 'scatter') value="scatter">Scatter</option>
                                <option @selected($table['tabel']->tipe == 'pie') value="pie">Pie</option>
                                <option @selected($table['tabel']->tipe == 'radar') value="radar">Radar</option>
                            </select>
                            <input type="hidden" name="id" value="{{ $table['tabel']->id }}">
                        </div>
                        @if ($table['tabel']->tipe == 'radar')  
                            <div class="form-group">
                                <label for="">Nilai maksimal per sumbu</label>
                                <input type="number" class="form-control" name="max_sumbu" value="{{ $table['tabel']->max_sumbu }}">
                            </div>
                        @else
                            <div class="form-group">
                                <label for="">Pilih Kolom</label>
                                <select name="pie_kolom" id="" class="form-control form-select">
                                    @foreach (array_slice($table['kolom'], 1) as $k)
                                        <option @selected($table['tabel']->pie_kolom == $k->id) value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-data-table :table="$table"></x-data-table>

    <!-- Chart JS -->
    <script src="{{ Vite::asset('resources/js/plugin/apache-echarts/echarts.min.js') }}"></script>
    <script>
        // Initialize the echarts instance based on the prepared dom
        var myChart = echarts.init(document.getElementById('barChart'));

        // Specify the configuration items and data for the chart
        var option = {
            tooltip: {},
            legend: {},

            @if ($table['tabel']->tipe == 'radar')
            radar: {
                indicator: @php echo json_encode($indicator); @endphp
            },
            @endif

            series: @php echo json_encode($series); @endphp
        };

        // Display the chart using the configuration items and data just specified.
        myChart.setOption(option);
        $(window).on('resize', function(event) {
            myChart.resize();
        })
    </script>
</x-root>
