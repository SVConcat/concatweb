<!DOCTYPE html>
<html>
<head>
    <title>Herinnering: Community Avond</title>
</head>
<body>
    <h1>Herinnering: {{ $communityNight->title }}</h1>

    <p>Beste student,</p>

    <p>Dit is een herinnering voor de aankomende community avond:</p>

    <ul>
        <li><strong>Titel:</strong> {{ $communityNight->title }}</li>
        <li><strong>Datum en Tijd:</strong> {{ $communityNight->full_start_time->format('d-m-Y H:i') }}</li>
        <li><strong>Locatie:</strong> {{ $communityNight->location ?? 'Nader te bepalen' }}</li>
        <li><strong>Beschrijving:</strong> {{ $communityNight->description }}</li>
    </ul>

    <p>Zorg dat je deze datum in je agenda zet! We zien je graag daar.</p>

    <p>Met vriendelijke groet,</p>
    <p>Concat</p>
</body>
</html>