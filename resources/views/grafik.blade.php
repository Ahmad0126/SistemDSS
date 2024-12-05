<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="row">
        <div class="col-lg-8">
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
                                    <textarea id="query" name="query" class="form-control" rows="5" placeholder="Masukkan Query Anda">{{ $grafik->query }} </textarea>
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
                    <x-data-table :baris="$baris" :kolom="$kolom"></x-data-table>
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

        // Initialize the echarts instance based on the prepared dom
        {{-- var myChart = echarts.init(document.getElementById('barChart'));

        // Specify the configuration items and data for the chart
        var option = {
            tooltip: {
                @if($table['tabel']->tipe == 'line')
                trigger: 'axis'
                @endif
            },
            grid:{
                left: '{{ $table['tabel']->ml }}%',
                right: '{{ $table['tabel']->mr }}%',
                top: '{{ $table['tabel']->mt }}%',
                bottom: '{{ $table['tabel']->mb }}%',
            },
            legend: {},

            @if ($table['tabel']->orientasi == 'v')
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
        $(window).on('resize', function(event) {
            myChart.resize();
        }) --}}
    </script>
</x-root>
