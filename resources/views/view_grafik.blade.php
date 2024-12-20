<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/kaiadmin.min.css') }}" />
    <title>{{ $title }} </title>
</head>

<body>
    <div class="chart-container" style="width: 100%; height: 100vh; background: white" id="chart">
        @if ($query_error)
            <div class="alert alert-danger">{{ $query_error }}</div>
        @endif
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
                        areaStyle: {},
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
    </script>
</body>

</html>