<!DOCTYPE html>
<html>
<head>
    <title>Herinnering: Evenement</title>
</head>
<body>
    <h1>Herinnering: {{ $event->titel }}</h1>

    <p>Beste student,</p>

    <p>Dit is een herinnering voor het aankomende evenement:</p>

    <ul>
        <li><strong>Titel:</strong> {{ $event->titel }}</li>
        <li><strong>Datum en Tijd:</strong> {{ \Carbon\Carbon::parse($event->datum . ' ' . $event->starttijd)->format('d-m-Y H:i') }}</li>
        <li><strong>Locatie:</strong> {{ $event->locatie ?? 'Nader te bepalen' }}</li>
        <li><strong>Beschrijving:</strong> {{ $event->beschrijving }}</li>
    </ul>

    <p>Zorg dat je deze datum in je agenda zet! We zien je graag daar.</p>

    <p>Met vriendelijke groet,</p>
    <p>Concat</p>
</body>
</html>