@extends('layouts.default')

@section('title', $assignment->title)

@section('content')
    <div class="section details">
        <div class="container has-sidebar">
            <div class="info">
                <div class="intro">
                    <h2>{{ $assignment->title }}</h2>
                    <p>
                        {!! $assignment->description !!}
                    </p>
                </div>
            </div>
            <div class="sidebar">
                <h2 class="has-background">Informatie</h2>
                <ul>
                    <li><span>Bedrijf:</span> {{ $assignment->company }}</li>
                    <li><span>Email:</span> <a href="mailto:{{ $assignment->contact_email }}">{{ $assignment->contact_email }}</a></li>
                    <li><span>Telefoonnummer:</span> <a href="tel:{{ $assignment->contact_phone }}">{{ $assignment->contact_phone }}</a></li>
                    <li><span>Website:</span> <a href="{{ $assignment->url }}" target="_blank">{{ $assignment->url }}</a></li>
                    @if($assignment->reward)
                        <li><span>Beloning:</span> €{{ number_format($assignment->reward, 2) }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@stop
