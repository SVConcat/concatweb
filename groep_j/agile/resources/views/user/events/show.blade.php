@extends('layouts.default')

@section('title', $event->title)

@section('content')
    <div class="section details">
        @if(session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container has-sidebar">
            <div class="info">
                <div class="intro">
                    <h2>{{$event->title}}</h2>
                    <p>
                        {!! $event->description !!}
                    </p>
                </div>
                <x-swiper :item="$event->sponsors" id="gallerySwiper"/>
                <x-swiper :item="$event" id="gallerySwiper"/>
            </div>
            <div class="sidebar">
                <h2 class="has-background">Informatie</h2>
                <h4>{{__($event->category->value)}}</h4>
                <p>{{ $event->status->name === 'ARCHIVED' ? '(' . __("ARCHIVED") . ')' : "" }}</p>
                <ul>
                    @if($event->location)
                        <li><span>Locatie:</span> {{$event->location}}</li>
                    @endif
                    @if($event->start_date && $event->end_date)
                        <li><span>Start datum:</span> {{$event->getFormattedDate($event->start_date)}}</li>
                        <li><span>Eind datum:</span> {{$event->getFormattedDate($event->end_date)}}</li>
                    @endif
                    @if(!$event->end_date)
                        <li><span>Datum:</span> {{$event->getFormattedDate($event->start_date)}}</li>
                    @endif
                    @if($event->price)
                        <li><span>Prijs:</span> {{$event->price}}</li>
                    @endif
                    @if($event->capacity)
                        <li><span>Aantal plaatsen:</span> {{$event->capacity}}</li>
                    @endif
                    @if($event->payment_link && !$event->weeztix_event_id)
                        <li><span>Betalen voor: </span><a href="{{$event->payment_link}}" target="_blank">{{$event->title}}</a></li>
                    @endif
                </ul>
                @auth
                    @if($event->is_open && !$event->weeztix_event_id && $event->registry_percentage >= 100 && $event->isRegistered() && !$event->payment_link)
                        <form action="{{route('user.event.unregister', $event->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="item-button">
                               Afmelden
                            </button>
                        </form>
                    @elseif($event->is_open && !$event->weeztix_event_id && $event->registry_percentage < 100 && !$event->payment_link)
                        <form action="{{ $event->isRegistered() ? route('user.event.unregister', $event->id) : route('user.event.register', $event->id) }}" method="POST">
                            @csrf
                            @if($event->isRegistered())
                                @method('DELETE')
                            @endif
                            <button type="submit" class="item-button">
                                {{ $event->isRegistered() ? 'Afmelden' : 'Inschrijven' }}
                            </button>
                        </form>
                    @elseif($event->weeztix_event_id && $availability < 100)
                        @if($event->isRegistered())
                            <span class="item-button">Ingeschreven</span>
                        @else
                            <a href="https://shop.weeztix.com/3fab2a15-071c-11f0-a9cb-7e126431635e/tickets" class="no-line button item-button" target="_blank">Inschrijven</a>
                        @endif
                    @elseif(($event->weeztix_event_id && $availability >= 100) || $event->registry_percentage >= 100 || (!$event->is_open && $event->capacity > 0))
                        <span class="item-button">Geen plaatsen meer beschikbaar</span>
                    @endif
                @else
                    @if(($event->registry_percentage >= 100 || $event->availability >= 100) && ($event->is_open || $event->weeztix_event_id))
                        <span class="item-button">Geen plaatsen meer beschikbaar</span>
                    @else
                        <a href="{{ route('login') }}" class="">Login om in te schrijven</a>
                    @endif
                @endauth
                @if($event->banner && $event->category->value === \App\Enums\EventCategoryEnum::COMMUNITY->value)
                    <div class="image-block">
                        <img src="{{ asset($event->banner_url) }}" alt="{{ $event->title }}">
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
