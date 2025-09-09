<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validatie Taalregels
    |--------------------------------------------------------------------------
    |
    | De volgende taalregels bevatten de standaard foutmeldingen die gebruikt
    | worden door de validatieklasse. Sommige van deze regels hebben meerdere
    | versies, zoals de regels voor grootte. Je kunt deze berichten aanpassen
    | aan de vereisten van jouw applicatie.
    |
    */

    'accepted' => 'Het veld :attribute moet geaccepteerd worden.',
    'accepted_if' => 'Het veld :attribute moet geaccepteerd worden wanneer :other :value is.',
    'active_url' => 'Het veld :attribute moet een geldige URL zijn.',
    'after' => 'Het veld :attribute moet een datum na :date zijn.',
    'after_or_equal' => 'Het veld :attribute moet een datum zijn die gelijk is aan of later dan :date.',
    'alpha' => 'Het veld :attribute mag alleen letters bevatten.',
    'alpha_dash' => 'Het veld :attribute mag alleen letters, cijfers, streepjes en underscores bevatten.',
    'alpha_num' => 'Het veld :attribute mag alleen letters en cijfers bevatten.',
    'array' => 'Het veld :attribute moet een array zijn.',
    'before' => 'Het veld :attribute moet een datum voor :date zijn.',
    'before_or_equal' => 'Het veld :attribute moet een datum zijn die gelijk is aan of eerder dan :date.',
    'between' => [
        'numeric' => 'Het veld :attribute moet tussen :min en :max liggen.',
        'file' => 'Het veld :attribute moet tussen :min en :max kilobytes zijn.',
        'string' => 'Het veld :attribute moet tussen :min en :max tekens bevatten.',
        'array' => 'Het veld :attribute moet tussen :min en :max items bevatten.',
    ],
    'boolean' => 'Het veld :attribute moet waar of onwaar zijn.',
    'confirmed' => 'De bevestiging van het veld :attribute komt niet overeen.',
    'date' => 'Het veld :attribute moet een geldige datum zijn.',
    'date_equals' => 'Het veld :attribute moet een datum zijn die gelijk is aan :date.',
    'date_format' => 'Het veld :attribute moet het formaat :format hebben.',
    'different' => 'Het veld :attribute en :other moeten verschillend zijn.',
    'digits' => 'Het veld :attribute moet :digits cijfers bevatten.',
    'digits_between' => 'Het veld :attribute moet tussen :min en :max cijfers bevatten.',
    'email' => 'Het veld :attribute moet een geldig e-mailadres zijn.',
    'exists' => 'De geselecteerde waarde voor :attribute is ongeldig.',
    'file' => 'Het veld :attribute moet een bestand zijn.',
    'filled' => 'Het veld :attribute moet een waarde hebben.',
    'gt' => [
        'numeric' => 'Het veld :attribute moet groter zijn dan :value.',
        'file' => 'Het veld :attribute moet groter zijn dan :value kilobytes.',
        'string' => 'Het veld :attribute moet meer dan :value tekens bevatten.',
        'array' => 'Het veld :attribute moet meer dan :value items bevatten.',
    ],
    'gte' => [
        'numeric' => 'Het veld :attribute moet groter dan of gelijk aan :value zijn.',
        'file' => 'Het veld :attribute moet groter dan of gelijk aan :value kilobytes zijn.',
        'string' => 'Het veld :attribute moet ten minste :value tekens bevatten.',
        'array' => 'Het veld :attribute moet ten minste :value items bevatten.',
    ],
    'image' => 'Het veld :attribute moet een afbeelding zijn.',
    'in' => 'Het geselecteerde :attribute is ongeldig.',
    'integer' => 'Het veld :attribute moet een geheel getal zijn.',
    'ip' => 'Het veld :attribute moet een geldig IP-adres zijn.',
    'json' => 'Het veld :attribute moet een geldige JSON-string zijn.',
    'max' => [
        'numeric' => 'Het veld :attribute mag niet groter zijn dan :max.',
        'file' => 'Het veld :attribute mag niet groter zijn dan :max kilobytes.',
        'string' => 'Het veld :attribute mag niet meer dan :max tekens bevatten.',
        'array' => 'Het veld :attribute mag niet meer dan :max items bevatten.',
    ],
    'min' => [
        'numeric' => 'Het veld :attribute moet minstens :min zijn.',
        'file' => 'Het veld :attribute moet minstens :min kilobytes zijn.',
        'string' => 'Het veld :attribute moet minstens :min tekens bevatten.',
        'array' => 'Het veld :attribute moet minstens :min items bevatten.',
    ],
    'not_in' => 'Het geselecteerde :attribute is ongeldig.',
    'numeric' => 'Het veld :attribute moet een getal zijn.',
    'password' => [
        'letters' => 'Het veld :attribute moet minstens één letter bevatten.',
        'mixed' => 'Het veld :attribute moet minstens één hoofdletter en één kleine letter bevatten.',
        'numbers' => 'Het veld :attribute moet minstens één cijfer bevatten.',
        'symbols' => 'Het veld :attribute moet minstens één speciaal teken bevatten.',
        'uncompromised' => 'Het opgegeven :attribute is gevonden in een datalek. Kies een ander wachtwoord.',
    ],
    'present' => 'Het veld :attribute moet aanwezig zijn.',
    'regex' => 'Het formaat van het veld :attribute is ongeldig.',
    'required' => 'Het veld :attribute is verplicht.',
    'required_if' => 'Het veld :attribute is verplicht wanneer :other :value is.',
    'required_with' => 'Het veld :attribute is verplicht wanneer :values aanwezig is.',
    'required_without' => 'Het veld :attribute is verplicht wanneer :values niet aanwezig is.',
    'same' => 'Het veld :attribute en :other moeten overeenkomen.',
    'size' => [
        'numeric' => 'Het veld :attribute moet :size zijn.',
        'file' => 'Het veld :attribute moet :size kilobytes zijn.',
        'string' => 'Het veld :attribute moet :size tekens bevatten.',
        'array' => 'Het veld :attribute moet :size items bevatten.',
    ],
    'string' => 'Het veld :attribute moet een string zijn.',
    'timezone' => 'Het veld :attribute moet een geldige tijdzone zijn.',
    'unique' => 'Het veld :attribute is al in gebruik.',
    'uploaded' => 'Het veld :attribute kon niet worden geüpload.',
    'url' => 'Het veld :attribute moet een geldige URL zijn.',
    'uuid' => 'Het veld :attribute moet een geldige UUID zijn.',

    /*
    |--------------------------------------------------------------------------
    | Aangepaste validatieberichten
    |--------------------------------------------------------------------------
    |
    | Hier kun je aangepaste validatieberichten definiëren voor specifieke
    | attributen en validatieregels.
    |
    */

    'custom' => [
        'email' => [
            'required' => 'Het e-mailadres is verplicht.',
            'email' => 'Vul een geldig e-mailadres in.',
        ],
        'password' => [
            'required' => 'Het wachtwoord is verplicht.',
            'min' => 'Het wachtwoord moet minimaal :min tekens lang zijn.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Aangepaste validatie-attributen
    |--------------------------------------------------------------------------
    |
    | De volgende taalregels worden gebruikt om onze attributen te vervangen
    | door iets vriendelijkers, zoals "E-mailadres" in plaats van "email".
    |
    */

    'attributes' => [
        'email' => 'e-mailadres',
        'password' => 'wachtwoord',
        'name' => 'naam',

        'title' => 'titel',
        'description' => 'omschrijving',
        'image' => 'afbeelding',
    ],

];
