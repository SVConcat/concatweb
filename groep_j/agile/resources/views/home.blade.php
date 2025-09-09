@extends("layouts.default")

@section("title", "Home")

@section("content")
    <div class="concat-banner">
        <div class="concat-title">
            <div>
                <h2>Welkom bij</h2>
                <h1>Studievereniging<br/>Concat</h1>
            </div>
            <img src="/assets/images/logo-white.svg" alt="Concat Logo">
            <div class="real-pseudo-element"></div>
        </div>
    </div>

    <div class="section">
            <div class="container has-sidebar">
                <div class="items-wrapper">
                    <div class="items">
                        @foreach($events as $event)
                            <x-item :item="$event" alt="{{$event->banner ? 'Poster voor '.$event->title : ''}}" route="user.event.show"/>
                        @endforeach
                    </div>
                </div>
                @if($homeImages->hasPhotos())
                    <div class="sidebar sideslider">
                        <x-swiper :item="$homeImages" id="homeSwiper" alt="title"/>
                    </div>
                @endif
            </div>
    </div>
@stop


