<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CommunityNight;
use App\Models\Event;
use Carbon\Carbon;
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

        $announcements = Announcement::where('isVisible', true)
            ->orderByDesc('published_at')
            ->get();

        // Group announcements by date
        $groupedAnnouncements = $this->groupAnnouncements($announcements);
        $communityNight = CommunityNight::latestCommunityNight();
        $latestEvent = Event::latestEvent();

        return view('home', [
            'photos' => $photos,
            'groupedAnnouncements' => $groupedAnnouncements,
            'latestEvent' => $latestEvent,
            'registeredCount' => $latestEvent->registrations()->count(),
            'availableSpots' => $latestEvent->aantal_beschikbare_plekken,
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

    private function getDateGroup(Carbon $date)
    {
        $now = now();
        $date = $date->copy()->startOfDay();

        if ($date->isToday()) {
            return 'Vandaag';
        } elseif ($date->isYesterday()) {
            return 'Gisteren';
        } elseif ($date->isSameWeek($now)) {
            return 'Deze Week';
        } elseif ($date->isSameWeek($now->copy()->subWeek())) {
            return 'Vorige Week';
        } elseif ($date->isSameMonth($now)) {
            return 'Deze Maand';
        } elseif ($date->isSameMonth($now->copy()->subMonth())) {
            return 'Vorige Maand';
        }

        return $date->translatedFormat('F Y');
    }
}
