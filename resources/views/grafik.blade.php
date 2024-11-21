<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>
    <x-slot:menu>
        <li class="nav-item">
            <a href="{{ route('tabel', $table['tabel']->id) }}">
                <i class="fas fa-layer-group"></i>
                <p>Data</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('struktur', $table['tabel']->id) }}">
                <i class="fas fa-th-list"></i>
                <p>Struktur Tabel</p>
            </a>
        </li>
        <li class="nav-item active">
            <a href="{{ route('grafik', $table['tabel']->id) }}">
                <i class="far fa-chart-bar"></i>
                <p>Grafik</p>
            </a>
        </li>
    </x-slot:menu>

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
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Settings</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('simpan_grafik') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Tipe</label>
                            <select name="tipe" id="" class="form-control form-select" onchange="this.form.submit()">
                                <option @selected($table['tabel']->tipe == 'bar') value="bar">Bar</option>
                                <option @selected($table['tabel']->tipe == 'line') value="line">Line</option>
                                <option @selected($table['tabel']->tipe == 'scatter') value="scatter">Scatter</option>
                                <option @selected($table['tabel']->tipe == 'pie') value="pie">Pie</option>
                                <option @selected($table['tabel']->tipe == 'radar') value="radar">Radar</option>
                            </select>
                            <input type="hidden" name="id" value="{{ $table['tabel']->id }}">
                        </div>
                        <div class="form-group">
                            <label for="">Orientasi</label>
                            <select name="orientasi" id="" class="form-control form-select" onchange="this.form.submit()">
                                <option @selected($table['tabel']->orientasi == 'h') value="h">Horizontal</option>
                                <option @selected($table['tabel']->orientasi == 'v') value="v">Vertikal</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="flip" value="true" id="flip">
                            <label class="form-check-label" for="flip">
                                Balikkan Kolom dengan Baris
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart JS -->
    <script src="{{ Vite::asset('resources/js/plugin/apache-echarts/echarts.min.js') }}"></script>
    <script>
        // Initialize the echarts instance based on the prepared dom
        var myChart = echarts.init(document.getElementById('barChart'));

        // Specify the configuration items and data for the chart
        var option = {
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: @php echo json_encode(array_slice(array_column($table['kolom'], 'nama'), 1)); @endphp
            },

            @if($table['tabel']->orientasi == 'v')
                xAxis: {
                    type: 'value',
                    boundaryGap: [0, 0.01]
                },
                yAxis: {
                    type: 'category',
                    data: @php echo json_encode($data); @endphp
                },
            @else
                xAxis: {
                    data: @php echo json_encode($data); @endphp
                },
                yAxis: {},
            @endif

            series: @php echo json_encode($series); @endphp
        };

        // Display the chart using the configuration items and data just specified.
        myChart.setOption(option);
        $(window).on('resize', function(event){
            myChart.resize();
        })
    </script>
</x-root>
