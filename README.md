# concatweb

## Table of Contents

- [Setup](#setup)
    - [General](#general)
    - [Start the development server](#start-the-development-server)
- [Large File Uploads](#large-file-uploads)

## Setup

### General

1. Clone the GitHub repository either via the **cli** or **GitHub Desktop**
2. Navigate to the project directory
3. Run `composer install` and `npm install` to install dependencies
4. Copy the `.env.example` file to `.env` and configure the following variables:
    - All variables starting with `DB_` for your database connection
    - `APP_URL` to match your local development URL
    - `APP_KEY` by running `php artisan key:generate`
5. Create the database by running `php artisan migrate`
6. After that run `php artisan db:seed` to seed the database with initial data

### Start the development server

Run `php artisan serve` and `npm run dev` to start the Laravel development server and compile assets.

## Large File Uploads

If a file upload fails before Laravel validation, it is often because the **server's `upload_max_filesize` is smaller or
equal to the max size set in the request**.

Key points for developers:

- PHP blocks uploads exceeding `upload_max_filesize` before Laravel sees them.
- `post_max_size` must be at least as large as `upload_max_filesize`.
- The Laravel validator (`max:<size>`) only applies to files that successfully reach the server.
- **Always set the server's `upload_max_filesize` slightly higher than the max file size enforced in your form request**
  to avoid silent failures. Consider also handling `PostTooLargeException` in `Handler.php` to provide a clear error to
  users.


## Test plan
### Inhoudsopgave

- [CRUD functionaliteiten](#crud-functionaliteiten)
  - [Aanmaken](#aanmaken)
    - [Event](#event)
    - [Community avonden](#community-avonden)
    - [Sponsoren](#sporen)
    - [Bestuursleden](#bestuursleden)
    - [Announcements](#announcements)
    - [Galerij](#galerij)
    - [Account](#account)
  - [Bezoeken](#bezoeken)
    - [Event](#event)
    - [Community avonden](#community-avonden)
    - [Sponsoren](#sporen)
    - [Bestuursleden](#bestuursleden)
    - [Announcements](#announcements)
    - [Galerij](#galerij)
    - [Account](#account)
  - [Bewerken](#bewerken)
    - [Event](#event)
    - [Community avonden](#community-avonden)
    - [Sponsoren](#sporen)
    - [Bestuursleden](#bestuursleden)
    - [Announcements](#announcements)
    - [Galerij](#galerij)
    - [Account](#account)
  - [Verwijderen](#verwijderen)
    - [Event](#event)
    - [Community avonden](#community-avonden)
    - [Sponsoren](#sporen)
    - [Bestuursleden](#bestuursleden)
    - [Announcements](#announcements)
    - [Galerij](#galerij)
    - [Account](#account)
- [Andere functionaliteiten](#andere-functionaliteiten)
  - [Beheerder](#beheerder)
  - [Bezoeker](#bezoeker)
  - [Discord gebruiker](#discord-gebruiker)

## CRUD functionaliteiten

Voor deze functionaliteiten worden de volgende punten getest. Om te valideren of wijzigingen doorgevoerd zijn, wordt de website vanaf de gebruikerspagina bezocht en wordt er gekeken of de aanpassing zichtbaar is.

### Aanmaken

### Bezoeken

### Bewerken

### Verwijderen

- Event
- community avonden 
- sponsoren
- bestuursleden
- announcements
- galerij
- account (Admin/Gebruiker)

# Andere functionaliteiten

- **Beheerder:** beheren van beheerders
  - geef de beheerder rol aan een andere gebruiker.
  - haal de beheerder rol van een andere beheerder weg.
  - check of de wijzigingen door zijn gekomen door als die andere gebruiker/beheerder in te loggen.
- **Beheerder:** inzien van avans agenda’s
  - het rooster van een klas via een avans kalender toevoegen aan het overzicht.
  - het rooster van een klas via een avans kalender verwijderen uit het overzicht.
  - kijk of de evenementen juist ingeladen worden volgens het daadwerkelijke rooster van die klas.
- **Bezoeker:** inschrijven voor evenement
  - inschrijven voor een evenement als student en kijken of dat zichtbaar is.
- **Bezoeker:** ics bestanden downloaden
  - navigeer naar de … en download de agenda.
  - bekijk of deze up-to-date is met de huidige planning.
- **Bezoeker:** pdf’s downloaden
  - download een nieuwsbrief PDF.
- **Discord gebruiker:** discord integratie
  - aanmaken van een evenement en melding en kijken of die in discord verschijnen.
- **Bezoeker:** account aanmaken
  - account aanmaak proces volgen en testen of je daarna in kan loggen.
- **Bezoeker:** herinnering over events (**n.v.t. voor nu**)
- **Beheerder:** afbeelding uploaden
  - upload een afbeelding van 2mb.
  - maak een foto met je telefoon en upload deze vanaf je telefoon naar de galerij.
- **Bezoeker:** carrousel afbeelding check
  - zijn de gewenste afbeeldingen weergegeven op de web page.
