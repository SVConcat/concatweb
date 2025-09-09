@component('mail::message')
    <p class="title-text">{{ $payload['title'] }}</p>

    {!! nl2br(e($payload['body'])) !!}

    @if(!empty($payload['imageUrl']))
        <img src="{{ asset($payload['imageUrl']) }}" alt="Afbeelding" class="email-image">
    @endif

    @if($payload['type'] === 'announcement')
        @component('mail::button', ['url' => route('user.announcement.show', ['id' => $payload['id']])])
            Bekijk aankondiging
        @endcomponent
    @endif

    @if($payload['type'] === 'event')
        @component('mail::button', ['url' => route('user.event.show', ['id' => $payload['id']])])
            Bekijk evenement op onze site voor meer informatie
        @endcomponent
    @endif

    Met vriendelijke groeten,<br>
    Concat

    @slot('subcopy')
        <p class="subcopy-text">
            Je ontvangt deze mail omdat je hebt ingeschreven voor nieuws.
            <a href="{{ route('user.profile.index') }}">Uitschrijven</a>
        </p>
    @endslot
@endcomponent
