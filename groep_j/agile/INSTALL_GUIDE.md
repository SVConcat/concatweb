# Install Guide Local Development Concept500

## Windows
- download PHP 8.X of hoger ( https://windows.php.net/download#php-8.3 ) ( Thread Safe version, ZIP )
- Om concept te kunnen starten zul je de volgende PHP extensies aan moeten zetten in je php.ini file
    - extension=curl
    - extension=fileinfo
    - extension=gd
    - extension=intl
    - extension=mbstring
    - extension=openssl
    - extension=pdo_mysql

- deze moet zo staan `variables_order = "GPCS"` ipv `variables_order = "EGPCS"`

- Zorg dat docker desktop geïnstalleerd is, voer dan het commando `docker-compose up -d of klik op dubbele pijl bij services in docker-compose.yml` uit in de root van het project
- Open een terminal in de root van het project en voer het commando `composer install` uit
- Voer ook het commando `npm install` uit in de root van het project
- Maak een `.env` bestand aan in de root van het project en kopieer de inhoud van `gedeelde .env` hierin.
    - check of `APP_LOCALE=` op `nl` staat en niet op `en`.
    - check of `APP_TIMEZONE=` op `CET` staat en niet op `UTC`.
    - check of `APP_NAME=` op `SVConcat` staat en niet op `Laravel`.
- Voer het command `php artisan migrate:fresh` uit in de root van het project (voert alle migrations uit en leegt de database als deze er is)
- Voer het commando `php artisan db:seed` uit in de root van het project (voert alle seeders uit)
- Voer het commando `php artisan db:seed --class=GallerySeeder` uit in de root van het project (voert de seeder voor de gallery uit)
- Voer het commando `php artisan db:seed --class=VerificationSeeder` uit in de root van het project (voert de seeder voor de verification uit) 
- voer het commando `npm run dev` uit in de root van het project (compileert de assets)
- voer het commando `php artisan serve` uit in de root van het project (start de server)
- Als het goed is draait de website nu op `localhost:8000 of 127.0.0.1`

## env
- `APP_LOCALE=nl` zorgt ervoor dat de website in het Nederlands is
- `APP_TIMEZONE=CET` zorgt ervoor dat de tijd correct wordt weergegeven en wordt opgeslagen
- `WEEZTIX_ENABLED=true` zet de Weeztix-koppeling aan; laat op false als je hem niet gebruikt
- `OAUTH_CLIENT_ID=` jouw Weeztix OAuth-client-ID (leeg laten tot je die hebt)
- `OAUTH_CLIENT_SECRET=` bijbehorend Weeztix OAuth-secret
- `OAUTH_CLIENT_REDIRECT=` de callback-URL die je in Weeztix registreert
- `GOOGLE_CALENDAR_ENABLED=true` activeert synchronisatie met een agenda­provider
- `GOOGLE_CALENDAR_ID=` de kalender-ID die je via de gekozen provider ophaalt
- `DISCORD_BOT_NAME=` afzendernaam die in Discord-berichten wordt getoond
- `DISCORD_WEBHOOK_ANNOUNCEMENTS=` volledige webhook-URL van het Discord-kanaal voor meldingen
- `MAIL_MAILER=smtp` kiest uitgaande mail via SMTP; zet eventueel op log voor alleen lokaal loggen
- `MAIL_HOST=` SMTP-server van je provider (bijv. smtp.gmail.com of smtp.sendgrid.net)
- `MAIL_PORT=` poort die bij die server hoort (meestal 587 TLS of 465 SSL)
- `MAIL_USERNAME=` gebruikersnaam of API-key van de SMTP-service
- `MAIL_PASSWORD=` wachtwoord of token dat erbij hoort
- `MAIL_FROM_ADDRESS=` standaard afzender­adres
- `MAIL_ENCRYPTION=tls` of ssl afhankelijk van poort en provider
- `MAIL_FROM_NAME=` leesbare afzender­naam
- `MAIL_ENABLED=true` Om mails te enablen
- `AWS_ACCESS_KEY_ID=` access-key voor S3-achtige opslag (leeg laten als je geen S3 gebruikt)
- `AWS_SECRET_ACCESS_KEY=` bijbehorend secret
- `AWS_DEFAULT_REGION=` regio­code van de bucket (bijv. eu-west-1)
- `AWS_BUCKET=` naam van de bucket
- `AWS_USE_PATH_STYLE_ENDPOINT=false` alleen op true zetten bij een minio-achtige host

## commands
- het commando `php artisan` geeft een lijst van alle commands die je kunt uitvoeren
- het commando `php artisan make:controller ControllerName` maakt een nieuwe controller aan, dit geldt ook voor de andere commando's (controller is een voorbeeld)
- het commando `php artisan optimize:clear` cleared de cache van de website
- het commando `php artisan migrate` voert de laatste migratie uit
- het commando `php artisan migrate:rollback` rolt de laatste migratie terug
- het commando `php artisan migrate:refresh` rolt alle migraties terug en voert ze opnieuw uit
- het commando `php artisan db:seed` voert alle seeders uit
- het commando `npm run dev` compileert de assets
- het commando `php artisan serve` start de server

### voor formatting
- het commando `./vendor/bin/pint` uit in de de root van het project om de code te formatten

## composer, npm
- `composer install` en `npm install` installeren alle benodigde packages voor het project wanneer er nieuwe packages zijn toegevoegd
