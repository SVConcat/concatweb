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
                'src' => asset('assets/images/jules_concat.png')
            ],
            [
                'title' => 'Workshop PHP',
                'date' => '15-03-2024',
                'src' => 'https://media.printables.com/media/prints/f3353adc-083b-4e3a-9b87-752574fc9f0f/images/9693228_4f10ea7a-9925-474a-8110-02e7d5028e3a_c9858f90-6660-45f0-8de8-e6da08b80e95/thumbs/inside/1280x960/jpg/20250506_134530.webp'
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
