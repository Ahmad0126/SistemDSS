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
                        <div class="form-group">
                            <label for="">Orientasi</label>
                            <select name="orientasi" id="" class="form-control form-select">
                                <option @selected($table['tabel']->orientasi == 'h') value="h">Horizontal</option>
                                <option @selected($table['tabel']->orientasi == 'v') value="v">Vertikal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <label for="">Margin Kanan</label>
                                    <input type="range" class="form-range" min="0" max="100" name="mr" id="mr" value="{{ $table['tabel']->mr }}">
                                </div>
                                <div class="col-5">
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" name="" id="lmr" class="form-control" value="{{ $table['tabel']->mr }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <label for="">Margin Kiri</label>
                                    <input id="ml" type="range" class="form-range" min="0" max="100" name="ml" value="{{ $table['tabel']->ml }}">
                                </div>
                                <div class="col-5">
                                    <div class="input-group">
                                        <input id="lml" type="number" min="0" max="100" name="" class="form-control" value="{{ $table['tabel']->ml }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <label for="">Margin Atas</label>
                                    <input id="mt" type="range" class="form-range" min="0" max="100" name="mt" value="{{ $table['tabel']->mt }}">
                                </div>
                                <div class="col-5">
                                    <div class="input-group">
                                        <input id="lmt" type="number" min="0" max="100" name="" class="form-control" value="{{ $table['tabel']->mt }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <label for="">Margin Bawah</label>
                                    <input id="mb" type="range" class="form-range" min="0" max="100" name="mb" value="{{ $table['tabel']->mb }}">
                                </div>
                                <div class="col-5">
                                    <div class="input-group">
                                        <input id="lmb" type="number" min="0" max="100" name="" class="form-control" value="{{ $table['tabel']->mb }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-data-table :table="$table"></x-data-table>

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
        var myChart = echarts.init(document.getElementById('barChart'));

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
        })
    </script>
</x-root>
