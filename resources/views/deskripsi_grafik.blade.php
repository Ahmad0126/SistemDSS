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
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Deskripsi</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Judul</label>
                                <div class="card-title">{{ $grafik->judul }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12">
                            <div class="form-group">
                                <label for="">Publisher</label>
                                <h5>{{ $grafik->nama }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12">
                            <div class="form-group">
                                <label for="">Dibuat Pada: </label>
                                <b>{{ date('j F Y H:i', strtotime($grafik->created_at)) }}</b>
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('show_grafik', $grafik->id) }}" target="_blank" class="btn btn-info">Fullscreen <i class="fas fa-external-link-alt"></i></a>
                            <button id="link" class="btn btn-secondary" data-link="{{ route('show_grafik', $grafik->id) }}">Link iframe</button>
                            @auth
                                @if ($grafik->id_user == auth()->id())
                                    <a href="{{ route('unpublish_grafik', $grafik->id_grafik) }}" class="btn btn-warning"
                                        onclick="return confirm('Yakin unpublish grafik ini?')">
                                        Unpublish
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/plugin/apache-echarts/echarts.min.js') }}"></script>
    <script>
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
                    top: 20,
                    right: 4,
                },
                @if ($grafik->tipe == 'radar')
                    radar: {
                        indicator: chartColumns.slice(1).map(col => ({
                            name: col, // Nama sumbu berdasarkan nama kolom
                            @if($grafik->max_sumbu)
                                max: {{ $grafik->max_sumbu }}  // Maksimum nilai sumbu (bisa diatur dinamis)
                            @endif
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
                            type: '{{ $grafik->tipe ?? "bar" }}',
                            name: col,
                            symbol: 'none',
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
                            type: '{{ $grafik->tipe ?? "bar" }}',
                            name: col,
                            symbol: 'none',
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
            document.getElementById('chart').innerHTML = 
                '<div class="alert alert-danger">{{ $query_error ?? 'Insufficient data to render chart.' }}</div>';
        }
    
        $('#link').click(function(){
            const link = $(this).data('link')
            navigator.clipboard.writeText(link)

            $.notify({
                title: 'OK',
                message: 'Link disalin ke clipboard',
                icon: 'fas fa-clipboard',
            }, {
                type: 'success',
                placement: {
                    from: 'top',
                    align: 'right',
                },
                time: 1000,
                delay: 3000,
            });
        })
    </script>
</x-root>