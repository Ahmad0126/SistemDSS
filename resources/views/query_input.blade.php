<x-root>
    <x-slot:title>{{ $title }} </x-slot:title>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('run_query') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="query" id="" cols="30" rows="10" class="form-control">{{ old('query') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Run
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-root>