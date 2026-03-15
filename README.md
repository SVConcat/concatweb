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

tijdens het aanmaken of aanpassen van een item moeten de volgende dingen getest worden:

- validatie voor lege waarden
- lower en upper bound testen voor numerieke waarden en datums
- maximum lengte testen voor text velden

de volgende CRUD functionaliteiten worden getest:

- Event
  - [ ] Maak een event aan
  - [x] Pas een event aan
  - [ ] Bekijk een event
  - [x] Verwijder een event
- Community avonden 
  - [x] maak een community avond aan
  - [x] pas een community avond aan
  - [x] bekijk een community avond
  - [x] verwijder een community avond
- Sponsoren
  - [ ] Maak een sponsor aan
  - [ ] Pas een sponsor aan
  - [ ] Bekijk de sponsoren
  - [ ] Verwijder een sponsor 
- Bestuursleden
  - [ ] Maak een event aan
  - [ ] Pas een event aan
  - [ ] Bekijk een event
  - [ ] Verwijder een event
- Opdrachten
  - [x] Maak een opdracht aan
  - [x] Pas een opdracht aan
  - [x] Bekijk een opdracht
  - [x] Verwijder een opdracht
- Announcements
  - [x] Maak een announcement aan
  - [x] Pas een announcement aan
  - [x] Bekijk een announcement
  - [x] Verwijder een announcement
- Galerij
  - [ ] upload een foto naar de galerij
  - [ ] Pas een foto aan
  - [ ] bekijk de galerij
  - [ ] verwijder een foto
- Account (Admin/Gebruiker)
  - [ ] account maken
  - [ ] profiel pagina bezoeken
  - [ ] eigen account wijzigen

# Andere functionaliteiten

- [ ] **Beheerder:** inzien van avans agenda’s  
  Test data: 1 beheerder account (A) + Haal rooster URL’s op met namen “OB101“ en “OB102“ (mits deze lokalen nog bestaat) via rooster.avans.one
  - Log in op een beheerder account en voer per URL het rooster in van “OB101” en “OB102“ bij het toevoegen van een rooster (**exacte navigatiepad benoemen**)
  - Navigeer naar het rooster overzicht en check of dezelfde rooster items zichtbaar zijn, zoals  op “rooster.avans.one” (**exacte navigatiepad benoemen**)
  - Verwijder het rooster van “OB102“
  - Controleer of deze nog zichtbaar is op het rooster overzicht

- [ ] **Bezoeker:** inschrijven voor evenement
  Testdata: Evenement (A), standaard account (A)
  - Login met account (A)
  - Navigeer naar evenement (A)
  - Schrijf account (A) in voor evenement (A)
  - Controleer of de inschrijving is doorgekomen (**op basis van welke visual cue?**)

- [ ] **Bezoeker:** .ics bestand downloaden  
  Test data: Evenement (A)
  - Navigeer naar de … en download de agenda (**exacte navigatiepad benoemen**)
  - Bekijk of evenement (A) zichtbaar is op de aangegeven datum

- [ ] **Discord gebruiker:** discord integratie  
  Test data: Beheerder account (A), Test discord server (A)
  - Log in met account (A)
  - Maak een communityavond aan
  - Maak een evenement aan
  - Maak een announcement aan
  - Controleer op de discord server of de bovenstaande entiteiten zijn binnengekomen in de bestemde kanalen

- [ ] **Bezoeker:** Account aanmaken
  - Maak een account aan
  - Log uit het account
  - Log opnieuw in

- [ ] **Beheerder:** afbeelding uploaden
  Testdata: Afbeelding van >2mb
  - Log in als beheerder
  - Upload een afbeelding van >2mb bij de galerij
  - Log in als beheerder op de telefoon
  - Maak een foto met de telefoon en upload deze naar de galerij

- [ ] **Bezoeker:** Carrousel afbeelding check
  Testdata: De gewenste afbeeldingen
  - Controleer of de gewenste afbeeldingen staan weergegeven op de hoofdpagina

- [ ] **Beheerder:** beheren van beheerder rollen  
  Test data: 1 beheerder account (A), 1 gebruikersaccount (B)
  - Log in met account (A) en wijs de beheerder rol toe aan account (B)
  - Log in met account (B) en ontneem de beheerder rol van beheerder account (A)
  - Log in met account (A) en check of de CRUD functionaliteiten nog zichtbaar zijn

- [ ] **Bezoeker:** herinnering over events __(n.v.t. voor nu)__

- [ ] **Bezoeker:** nieuwsbrief pdf downloaden __(n.v.t. voor nu)__
