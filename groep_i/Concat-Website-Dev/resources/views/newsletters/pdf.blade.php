<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #6b21a8;
            border-bottom: 3px solid #6b21a8;
            padding-bottom: 10px;
        }

        .event {
            border: 2px solid #6b21a8;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            background-color: #f3e8ff;
        }

        .event h2 {
            color: #4c1d95;
            margin-bottom: 5px;
        }

        .event .info {
            font-size: 14px;
            margin: 5px 0;
        }

        .event .info strong {
            color: #000;
        }

        .event p {
            margin-top: 10px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <p style="text-align: center; font-size: 14px;">
        <strong>Publicatiedatum:</strong> {{ $publicatiedatum }}
    </p>

    @foreach ($events as $index => $event)
        <div class="event">
            <h2>{{ $event['titel'] }}</h2>
            @if (!empty($event['datum']))
                <div class="info"><strong>Datum:</strong> {{ $event['datum'] }}</div>
            @endif
            @if (!empty($event['tijd']))
                <div class="info"><strong>Tijd:</strong> {{ $event['tijd'] }}</div>
            @endif
            @if (!empty($event['locatie']))
                <div class="info"><strong>Locatie:</strong> {{ $event['locatie'] }}</div>
            @endif
            <p>{!! nl2br(e($event['inhoud'])) !!}</p>

            @if (!empty($images) && !empty($images[$index]))
                <div class="image-container">
                    <img src="{{ public_path($images[$index]) }}" alt="Afbeelding">
                </div>
            @endif
        </div>
    @endforeach
</body>

</html>