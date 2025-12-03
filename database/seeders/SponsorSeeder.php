<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sponsor::create([
            'name' => 'InfoSupport',
            'description' => "**Betrouwbare maatwerksoftware**\n" .
                             "Maatwerksoftware bouwen waar miljoenen mensen dagelijks gebruik van maken. Dat is ons werk. " .
                             "Voor grote gerenommeerde klanten in Nederland en België. Betrouwbaar, schaalbaar en onderhoudbaar. " .
                             "Wij gaan voor software oplossingen van zeer hoge kwaliteit. Binnen de afgesproken tijd en het budget. " .
                             "Door samen continu te vernieuwen helpen we klanten en de wereld significant vooruit. " .
                             "We vragen veel van je, maar daar krijg je ook veel voor terug. " .
                             "Een loopbaan bij Info Support biedt garantie voor een succesvolle IT-carrière en werken aan uitdagende projecten bij top 500 bedrijven als NS, Enexisen de RDW.\n\n" .
                             "**Altijd voorop in ontwikkelingen**\n" .
                             "Onze ambitie en drive maakt ons vastberaden om topkwaliteit te leveren en voorop te lopen. " .
                             "Daarom borgen wij nieuwe technologische ontwikkelingen en de toepasbaarheid ervan. " .
                             "En daar profiteer jij van. " .
                             "Je kunt je in een vroeg stadium verdiepen in de technologische mogelijkheden van de toekomst.",
            'url' => null,
            'image_path' => 'sponsor_logos/info_support.svg'
        ]);

        Sponsor::create([
           'name' => 'Formorrow',
           'description' => "**Voor de uitblinkers van morgen**\n" .
                            "Op zoek naar een baan in IT die écht bij jou past? " .
                            "Formorrow verbindt talent in IT met banen om in door te groeien. Met onze onderbouwde methode helpen we je om je toekomst zelf vorm te geven:\n\n" .
                            "**Know yourself**\n" .
                            "Natuurlijk gaat het ook om wat je kan, maar wij beginnen bij wie je bent. Test met de Discovery Day waar je krachten liggen en krijg een dieper inzicht in jezelf. " .
                            "Zo ontdekken we welke werkplek past bij je persoonlijkheid en talenten.\n\n" .
                            "**Find your match**\n" .
                            "Op basis van jouw inzichten uit de Discovery Day gaan we niet op zoek naar zomaar een baan, maar naar een loopbaan. " .
                            "Samen vinden we de werkgever waar je op je plek bent en waar je de ruimte krijgt om je te ontwikkelen. Vandaag — overmorgen nog steeds.\n\n" .
                            "**Grow ahead**\n" .
                            "Gestart met je baan? Dan start je ook aan onze Formorrow IT Academy. " .
                            "Twee jaar lang leer je alles wat je nodig hebt om je carrière vorm te geven. Je verdiept je zelfkennis. " .
                            "Versterkt je vak skills. En samen met je coach die altijd voor je klaar staat ontwikkel je een inspirerend carrièreplan.\n\n" .
                            "**Dus waarom Formorrow?**\n" .
                            "- Alles draait om wie jij bent en wat jij wil\n" .
                            "- Twee jaar lang ondersteunen wij jou bij elke stap die je maakt.\n" .
                            "- Met persoonlijke coaching, technische ontwikkeling, persoonlijke ontwikkeling en een geweldige community in de Formorrow Academy\n" .
                            "- Kies voor een carrière, niet alleeneen baan",
           'url' => 'https://www.formorrow.nl/',
           'image_path' => 'sponsor_logos/formorrow.svg'
        ]);

        Sponsor::create([
           'name' => 'Betabit',
           'description' => "Goede software begint bij slimme mensen. Maar om succes te boeken met je software, heb je vooral mensen nodig met een passie voor softwareontwikkeling. " .
                            "Wij ontwikkelen maatwerk software, de beste bedrijfskritischesystemen, die onze klanten succesvol maakt. " .
                            "Met ruim 15 jaar Azure ervaring zijn wij marktleider in softwareontwikkeling, -duiding en opleiding in Microsoft Azure. " .
                            "Met cloud-native development zetten we software-ideeën om in de perfecte applicatie. " .
                            "Dit doen onze consultants iedere dag voor onze klanten uit verschillende sectoren. " .
                            "Daarnaast werken wij ook aan in-house projecten met ons Managed Software Development Center (MSDC). " .
                            "Zij verzorgen de volledige levenscyclus van software, inclusiefideation, (door) ontwikkeling, onderhoud en het proactief beheer van applicaties. " .
                            "Hiermee ontzorgen wij de klant van A tot Z.\n\n" .
                            "**De Betabit Academie**\n" .
                            "Onze Academie helpt je om het meeste uit je talenten te halen. " .
                            "Onze klanten verwachten veel van ons en bovendien verandert het technologielandschap voortdurend: nieuwe producten, wetten en programmeer filosofieën komen en gaan. " .
                            "Wij zijn van mening dat kennisontwikkeling de kern is van de moderne medewerker. " .
                            "Het is van essentieel belang om bij te blijven. Daarom investeren we in onze talenten. " .
                            "Door de jaren heen hebben wij dat tot in de puntjes uitgewerkt en hebben wij speciale trajecten voor onze eigen medewerkers ontwikkeld.\n\n" .
                            "**Betabit Azure Talent programma**\n" .
                            "Twee keer per jaar start Betabit met een groep recent afgestudeerde hbo’ers en academici het Azure Talent Traineeship. " .
                            "Na een traject van vier en halve maand ga je aan de slag als junior developer voor een klant van Betabit. " .
                            "Je bent dan opgeleid tot full-stack Microsoft Azure developer volgens de normen van Betabit.",
           'url' => null,
           'image_path' => 'sponsor_logos/betabit.png'
        ]);

        Sponsor::create([
           'name' => 'Axians',
           'description' => "**The best of ICT with a human touch**\n" .
                            "Axians, het ICT-merk van VINCI Energies, staat voor innovatie, samenwerking en digitale transformatie. " .
                            "Onze missie? Het verbeteren van werk en leven, voor jou en de mensen om je heen. " .
                            "Verspreid over het hele land vind je onze Business Units: kleine, informele teams met hun eigen expertise. " .
                            "Deze teams werken zelfstandig en flexibel, wat zorgt voor een persoonlijke benadering voor onze klanten én veel vrijheid en verantwoordelijkheid voor onze medewerkers. " .
                            "Dit maakt het werk niet alleen uitdagend, maar vooral leuk!\n\n" .
                            "Wat ons uniek maakt, is dat je bij Axians het beste van twee werelden krijgt: de vrijheid van een klein team, gecombineerd met de kracht en mogelijkheden van het grote VINCI Energies netwerk. " .
                            "Dit biedt jou eindeloze kansen om samen te werken, te leren en door te groeien.\n\n" .
                            "Bij Axians draait alles om mensen. Onze betrokken en gedreven collega\'s maken het verschil, en daarom investeren we voortdurend in hun groei en ontwikkeling. " .
                            "Hier krijg je de ruimte om te ontdekken, te leren en het beste uit jezelf te halen!",
           'url' => null,
           'image_path' => 'sponsor_logos/axians.png'
        ]);
    }
}
