@extends("admin.index")

@section("title", "Weeztix")

@section("content")
    <div class="container">
        <div class="wrapper">
            <h2>Weeztix</h2>
            <div class="button-wrapper">
                @if(!$tokenExists)
                    <a href="{{route('admin.weeztix.create-token')}}" class="button">Maak de eerste Weeztix connectie aan</a>
                @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                @if($tokenExists)
                    <form action="{{route('admin.weeztix.refresh-token')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="button">Hernieuw de Weeztix token</button>
                        <p class="hint">Mocht de auto-refresh niet optijd werken, gebruik dan deze knop.</p>
                    </form>
                @endif
            </div>
        </div>
    </div>
@stop
