@extends("layouts.default")

@section("title", "Calender")

@section("content")
    <div class="section">
        <div class="container has-sidebar">
            <div class="calender-container">
                @if ($events->isNotEmpty())
                    <div class="calender">
                        @foreach ($events as $month => $monthEvents)
                            <div class="calender-month">
                                <h1>{{ __($month) }}</h1>
                                <ul>
                                    @foreach ($monthEvents as $event)
                                        <li>
                                            <strong>{{ $event->start_date->format('d-m-Y') }}</strong> -
                                            {{ $event->title }}
                                            <i>{{ __($event->category->value) }}</i>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="sidebar">
                @if(request('status') === 'my_events')
                    <h2 class="has-background">Eigen Agenda's</h2>
                    <p>Gefilterd op eigen activiteiten. Dus alleen de activiteiten waarvoor je bent ingeschreven zullen aan jouw eigen agenda worden toegevoegd.</p>
                @else
                    <h2 class="has-background">Agenda's</h2>
                @endif
                <span class="tip">
                    ?
                    <span class="tooltiptext">
                        <strong>Webcal</strong> is een link die je kan toevoegen aan je agenda. Wijzigingen kunnen enkele ogenblikken duren voordat deze zichtbaar zijn in je agenda.
                        <br />
                        @if(request('status') === null)
                            Door op de <strong>Google agenda</strong> knop te klikken wordt je automatisch doorgewezen naar je persoonlijke Google agenda waar de concat agenda is toegevoegd.
                            <br />
                        @endif
                        Het <strong>downloaden</strong> van de agenda is een moment opname van de agenda op dat moment. Dit is een .ics bestand die je kan importeren in je eigen agenda.
                    </span>
                </span>
                <br />
                <div class="buttons {{request('status') === 'my_events' ? 'my_events' : ''}}">
                    <button class="item-button" id="webcal" data-user-id="{{$user}}">Webcal</button>
                    @if(request('status') === null)
                        <a href="https://calendar.google.com/calendar/u/0?cid=NTUwYjc2YTM3N2JmNDg2MjNjYWY5MTIzMmY2ZjI1MzI0NWEyNWVkMjYzYmY3OGQ3NmVkNjIwNmJkOWEwMDNjMkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t" class="button item-button">Google agenda</a>
                    @endif
                    <a href="{{ route('calendar.ics.default', ['status' => request('status')]) }}" target="_blank" class="button item-button">Download</a>
                </div>
                <br />
                @if(auth()->check())
                <x-filters.dropdown :onchange="'this.form.submit()'" default="Alle activiteiten" label="Filter" name="status" :list="['my_events' => 'Mijn activiteiten']" value="{{ request('status') }}"/>
                @else
                    <p><a href="{{ route('login') }}" class="login-message">Log in</a> om te filteren op activiteiten waarvoor je bent ingeschreven.</p>
                @endif
            </div>
        </div>
    </div>
@stop
