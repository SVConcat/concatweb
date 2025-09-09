@extends("layouts.default")

@section("title", "Sponsors")

@section("content")
    <div class="section">
        <div class="container">
            <div class="instruction-message">
                <p>Wil je sponsor worden? Mail dan naar <a href="mailto:info@svconcat.nl">info@svconcat.nl</a></p>
            </div>
        </div>

        <div class="sponsors-overview">
            <div class="sponsors-container">
                @foreach($sponsors as $sponsor)
                    <div class="sponsor">
                        <a href="{{ $sponsor->url }}" class="no-line" target="_blank"><img src="{{ asset($sponsor->image_url)}}" alt="Logo van {{ $sponsor->name }}" class="sponsor-image"></a>
                        <h1 class="has-background">{{$sponsor->name}}</h1>
                        <p>{!! $sponsor->description !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container pagination-container">
            <div class="pagination">
                {{ $sponsors->links() }}
            </div>
        </div>
    </div>
@stop
