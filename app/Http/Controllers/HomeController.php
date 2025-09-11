<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function index()
    {
        // Foto's voor carrousel
        $photos = [
            [
                'title' => 'Studiereis Gent',
                'date' => '12-03-2024',
                'src' => asset('storage/gallery/concat_foto_1.png')
            ],
            [
                'title' => 'Workshop PHP',
                'date' => '15-03-2024',
                'src' => asset('storage/gallery/concat_foto_2.png')
            ],
            [
                'title' => 'Jaarlijks BBQ Feest',
                'date' => '18-03-2024',
                'src' => asset('storage/gallery/concat_foto_3.png')
            ],
            [
                'title' => 'Hackathon 2024',
                'date' => '20-03-2024',
                'src' => asset('storage/gallery/concat_foto_4.png')
            ],
            [
                'title' => 'Algemene Ledenvergadering',
                'date' => '22-03-2024',
                'src' => asset('storage/gallery/concat_foto_5.png')
            ],
            [
                'title' => 'Excursie Techbedrijf',
                'date' => '25-03-2024',
                'src' => asset('storage/gallery/concat_foto_6.png')
            ],
            [
                'title' => 'Introductieweek Nieuwe Studenten',
                'date' => '28-03-2024',
                'src' => asset('storage/gallery/concat_foto_7.png')
            ],
            [
                'title' => 'Codeersessie JavaScript',
                'date' => '01-04-2024',
                'src' => asset('storage/gallery/concat_foto_8.png')
            ],
            [
                'title' => 'Netwerkevent Partners',
                'date' => '05-04-2024',
                'src' => asset('storage/gallery/concat_foto_9.png')
            ],
            [
                'title' => 'Eindpresentaties Projecten',
                'date' => '10-04-2024',
                'src' => asset('storage/gallery/concat_foto_10.png')
            ]
        ];

        // Aankondigingen ophalen
        $announcements = Announcement::where('isVisible', true)
            ->orderByDesc('published_at')
            ->get();

        // Groepeer aankondigingen
        $groupedAnnouncements = $this->groupAnnouncements($announcements);

        // Laatste community en event ophalen
        $communityNight = App::make(CommunityNightController::class)->latest();
        $eventData = App::make(EventController::class)->latest();

        return view('home', [
            'photos' => $photos,
            'groupedAnnouncements' => $groupedAnnouncements,
            'event' => $eventData['event'],
            'registeredCount' => $eventData['registeredCount'],
            'availableSpots' => $eventData['availableSpots'],
            'communityNight' => $communityNight
        ]);
    }

    private function groupAnnouncements($announcements)
    {
        $grouped = [];
        foreach($announcements as $announcement) {
            $group = $this->getDateGroup($announcement->published_at);
            $grouped[$group][] = $announcement;
        }
        return $grouped;
    }

    private function getDateGroup($date)
    {
        $now = now();
        $date = $date->copy()->startOfDay();
        $diffInDays = $date->diffInDays($now);

        if($date->isToday()) return 'Vandaag';
        if($date->isYesterday()) return 'Gisteren';
        if($diffInDays <= 7) return 'Deze Week';
        if($diffInDays <= 14) return 'Vorige Week';
        if($date->month == $now->month && $date->year == $now->year) return 'Deze Maand';
        if($date->month == $now->subMonth()->month && $date->year == $now->year) return 'Vorige Maand';

        return $date->translatedFormat('F Y');
    }
}
