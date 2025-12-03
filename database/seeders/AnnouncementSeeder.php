<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the migrations.
     */
    public function run()
    {
        // Array of announcements with required fields
        $announcements = [
            [
                'titel' => 'ALV Komende Donderdag',
                'inhoud' => "Beste leden,\n\nDe algemene ledenvergadering vindt plaats op donderdag 16 november om 19:30 in zaal B3.12. Agenda:\n1. Financieel jaarverslag\n2. Bestuursverkiezingen\n3. Activiteitenplanning 2024\n\nZorg dat je erbij bent!",
                'published_at' => now()->subDays(2),
                'isVisible' => true,
            ],
            [
                'titel' => 'Deadline Thesis Workshop',
                'inhoud' => "⚠️ Deadline inschrijving thesisworkshop: 25 november!\n\nBen je bezig met je scriptie? Meld je nu aan voor onze workshop:\n- Hoe schrijf je een goede onderzoeksvraag?\n- Tijdmanagement tips\n- Feedbackrondes met ouderejaars\n\nAanmelden via de website!",
                'published_at' => now()->subDays(5),
                'isVisible' => true,
            ],
            [
                'titel' => 'Kerstdiner Commissie Vacatures',
                'inhoud' => "We zoeken nog commissieleden voor het kerstdiner!\nFuncties:\n- Cateringcoördinator\n- Decoratie team\n- Programmamanager\n\nInteresse? Mail naar kerst@sv-nexus.nl",
                'published_at' => now()->subDay(),
                'isVisible' => true,
            ],
            [
                'titel' => 'ARCHIEF: Studieweekend 2023 Foto\'s',
                'inhoud' => "De foto's van het studieweekend in Utrecht zijn nu beschikbaar in het besloten gedeelte van de website. Let op: deze zijn alleen voor leden zichtbaar!",
                'published_at' => Carbon::create(2023, 10, 15),
                'isVisible' => false,
            ],
            [
                'titel' => 'Introductie Nieuwe Leden',
                'inhoud' => "Welkom alle nieuwe leden! 🎉\n\nJullie ontvangen deze week een uitnodiging voor:\n- Kennismakingsborrel vrijdag\n- Rondleiding gebouw\n- Buddy matching\n\nCheck je mailbox!",
                'published_at' => now(),
                'isVisible' => true,
            ],
        ];

        // Insert each announcement into the database
        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
