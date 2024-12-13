<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <style>
                        svg{
                            height: 100%;
                            width: 100%;
                        }
                    </style>
                    <div class="chart-container" style="height: 465px" id="chart">
                        {!! $grafik->image !!}
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
    <script>
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