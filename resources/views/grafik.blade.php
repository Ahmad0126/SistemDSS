<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container" style="height: 465px" id="chart">
                        @if ($query_error)
                            <div class="alert alert-danger">{{ $query_error }}</div>
                        @endif
                    </div>
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
        <div class="col-lg-4">
            <div class="card">
                <form action="{{ route('simpan_grafik') }}" method="post">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title">Pengaturan</div>
                        <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
                    </div>
                    <div class="card-body" style="max-height: 435px; overflow-y: scroll">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Query</label>
                                    <textarea id="query" name="query" class="form-control" rows="5" placeholder="Masukkan Select Query">{{ $grafik->query }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="form-group">
                                    <label for="">Tipe Grafik</label>
                                    <select name="tipe" id="" class="form-control form-select">
                                        <option @selected($grafik->tipe == 'bar') value="bar">Bar</option>
                                        <option @selected($grafik->tipe == 'line') value="line">Line</option>
                                        <option @selected($grafik->tipe == 'scatter') value="scatter">Scatter</option>
                                        <option @selected($grafik->tipe == 'pie') value="pie">Pie</option>
                                        <option @selected($grafik->tipe == 'radar') value="radar">Radar</option>
                                    </select>
                                    <input type="hidden" name="id" value="{{ $grafik->id }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="form-group">
                                    <label for="">Orientasi</label>
                                    <select name="orientasi" id="" class="form-control form-select">
                                        <option @selected($grafik->orientasi == 'h') value="h">Horizontal</option>
                                        <option @selected($grafik->orientasi == 'v') value="v">Vertikal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <label for="">Margin Kanan</label>
                                            <input type="range" class="form-range" min="0" max="100" name="mr" id="mr" value="{{ $grafik->mr }}">
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group">
                                                <input type="number" min="0" max="100" name="" id="lmr" class="form-control" value="{{ $grafik->mr }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <label for="">Margin Kiri</label>
                                            <input id="ml" type="range" class="form-range" min="0" max="100" name="ml" value="{{ $grafik->ml }}">
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group">
                                                <input id="lml" type="number" min="0" max="100" name="" class="form-control" value="{{ $grafik->ml }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <label for="">Margin Atas</label>
                                            <input id="mt" type="range" class="form-range" min="0" max="100" name="mt" value="{{ $grafik->mt }}">
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group">
                                                <input id="lmt" type="number" min="0" max="100" name="" class="form-control" value="{{ $grafik->mt }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <label for="">Margin Bawah</label>
                                            <input id="mb" type="range" class="form-range" min="0" max="100" name="mb" value="{{ $grafik->mb }}">
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group">
                                                <input id="lmb" type="number" min="0" max="100" name="" class="form-control" value="{{ $grafik->mb }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header p-0">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <h3 class="navbar-brand mb-0 ms-2">Data</h3>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    @if (isset($kolom) && isset($baris))
                        <x-data-table :baris="$baris" :kolom="$kolom"></x-data-table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart JS -->
    <script src="{{ Vite::asset('resources/js/plugin/apache-echarts/echarts.min.js') }}"></script>
    <script>
        $('#mr').on('change', function(event){
            $('#lmr').val($(this).val())
        });
        $('#lmr').on('change', function(event){
            $('#mr').val($(this).val())
        });

        $('#ml').on('change', function(event){
            $('#lml').val($(this).val())
        });
        $('#lml').on('change', function(event){
            $('#ml').val($(this).val())
        });

        $('#mt').on('change', function(event){
            $('#lmt').val($(this).val())
        });
        $('#lmt').on('change', function(event){
            $('#mt').val($(this).val())
        });
        
        $('#mb').on('change', function(event){
            $('#lmb').val($(this).val())
        });
        $('#lmb').on('change', function(event){
            $('#mb').val($(this).val())
        });

        // Data dari backend
        const chartData = @json($baris ?? []);
        const chartColumns = @json($kolom ?? []);

        if (chartData.length > 0 && chartColumns.length > 1) {
            const chartDom = document.getElementById('chart');
            const myChart = echarts.init(chartDom);

            const option = {
                title: {
                    text: '{{ $grafik->judul }}'
                },
                tooltip: {
                    @if($grafik->tipe == 'line')
                        trigger: 'axis'
                    @endif
                },
                grid:{
                    left: '{{ $grafik->ml ?? 0 }}%',
                    right: '{{ $grafik->mr ?? 0 }}%',
                    top: '{{ $grafik->mt ?? 0 }}%',
                    bottom: '{{ $grafik->mb ?? 0 }}%',
                },
                legend: {
                    type: 'scroll',
                    top: 4,
                    right: 4,
                },
                @if ($grafik->tipe == 'radar')
                    radar: {
                        indicator: chartColumns.slice(1).map(col => ({
                            name: col, // Nama sumbu berdasarkan nama kolom
                            max: 100   // Maksimum nilai sumbu (bisa diatur dinamis)
                        }))
                    },
                    series: {
                        type: 'radar',
                        data: chartData.map(row => ({
                            value: chartColumns.slice(1).map(col => row[col]), // Ambil nilai setiap metrik
                            name: row[chartColumns[0]] // Ambil nama kategori (baris pertama)
                        }))
                    },
                @else
                    dataset: {
                        source: [
                            chartColumns, // Baris pertama adalah nama kolom (header)
                            ...chartData.map(row => chartColumns.map(col => row[col])) // Sisanya adalah data
                        ]
                    },
                    @if ($grafik->orientasi == 'v')
                        @if ($grafik->tipe != 'pie' && $grafik->tipe != 'radar')
                            xAxis: { type: 'value' },
                            yAxis: { type: 'category' },
                        @endif
                        series: chartColumns.slice(1).map(col => ({
                            type: '{{ $grafik->tipe ?? bar }}',
                            name: col,
                            @if ($grafik->tipe == 'pie')
                                encode: { itemName: chartColumns[0], value: col }
                            @else
                                encode: { y: chartColumns[0], x: col }
                            @endif
                        }))
                    @else
                        @if ($grafik->tipe != 'pie' && $grafik->tipe != 'radar')
                            xAxis: { type: 'category' },
                            yAxis: { type: 'value' },
                        @endif
                        series: chartColumns.slice(1).map(col => ({
                            type: '{{ $grafik->tipe ?? bar }}',
                            name: col,
                            @if ($grafik->tipe == 'pie')
                                encode: { itemName: chartColumns[0], value: col }
                            @else
                                encode: { x: chartColumns[0], y: col }
                            @endif
                        }))
                    @endif
                @endif
            };

            myChart.setOption(option);

            $(window).on('resize', function(event) {
                myChart.resize();
            })
        } else {
            document.getElementById('chart').innerHTML = '<div class="alert alert-danger">Insufficient data to render chart.</div>';
        }
    </script>
</x-root>
