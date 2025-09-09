@extends('layouts.default')

@section('title', $announcement->title)

@section('content')
    <div class="section details">
        <div class="container">
            <div class="info">
                <div class="intro">
                    <h2>{{$announcement->title}}</h2>
                    <p>
                        {!! $announcement->description !!}
                    </p>
                </div>
            </div>
            <div class="sidebar">
                <ul>
                    @if($announcement->updated_at)
                        <li><span>Gewijzigd op:</span> {{ $announcement->getFormattedDate($announcement->updated_at)}}</li>
                    @endif
                    @if($announcement->created_at)
                        <li><span>Aangemaakt op:</span> {{ $announcement->getFormattedDate($announcement->created_at)}}</li>
                    @endif
                </ul>
                @if($announcement->image)
                    <div class="image-block">
                        <img src="{{ asset($announcement->banner_url) }}" alt="{{ $announcement->title }}">
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
