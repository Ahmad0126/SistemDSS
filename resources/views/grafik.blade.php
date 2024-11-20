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
                    <div class="chart-container" id="barChart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Settings</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Tipe</label>
                        <select name="type" id="" class="form-control form-select">
                            <option value="bar">Bar</option>
                            <option value="line">Line</option>
                            <option value="scatter">Scatter</option>
                            <option value="pie">Pie</option>
                            <option value="radar">Radar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Orientasi</label>
                        <select name="orientation" id="" class="form-control form-select">
                            <option value="horizontal">Horizontal</option>
                            <option value="vertikal">Vertikal</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="flip" value="true" id="flip">
                        <label class="form-check-label" for="flip">
                            Balikkan Kolom dengan Baris
                        </label>
                    </div>
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
            tooltip: {},
            legend: {
                data: ['Bahasa Inggris', 'Bahasa Indonesia', 'Matematika']
            },
            xAxis: {
                data: @php echo json_encode(array_values($data)); @endphp
            },
            yAxis: {},
            series: @php echo json_encode(array_values($series)); @endphp
        };

        // Display the chart using the configuration items and data just specified.
        myChart.setOption(option);
        $(window).on('resize', function(event){
            myChart.resize();
        })
    </script>
</x-root>
