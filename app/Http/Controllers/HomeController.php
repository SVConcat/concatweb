<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CommunityNight;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        // Foto's voor carrousel
        $photos = [
            [
                'title' => 'Studiereis Gent',
                'date' => '05-07-2024',
                'src' => Storage::url('home_slider/slider-1.jpeg')
            ],
            [
                'title' => 'Studiereis Gent',
                'date' => '05-07-2024',
                'src' => Storage::url('home_slider/slider-2.jpeg')
            ],
            [
                'title' => 'Studiereis Gent',
                'date' => '06-07-2024',
                'src' => Storage::url('home_slider/slider-3.jpeg')
            ],
            [
                'title' => 'Kerstborrel',
                'date' => '22-11-2022',
                'src' => Storage::url('home_slider/slider-4.jpeg')
            ],
            [
                'title' => 'Pubquiz met formorrow',
                'date' => '12-01-2026',
                'src' => Storage::url('home_slider/slider-5.jpeg')
            ],
        ];

        $announcements = Announcement::where('isVisible', true)
            ->orderByDesc('published_at')
            ->get();

        // Group announcements by date
        $groupedAnnouncements = $this->groupAnnouncements($announcements);
        $communityNight = CommunityNight::latestCommunityNight();
        $latestEvent = Event::latestEvent();

        $registeredCount = 0;
        $availableSpots = 0;
        if($latestEvent != null){
            $registeredCount = $latestEvent->registrations()->count();
            $availableSpots = $latestEvent->aantal_beschikbare_plekken;
        }
        return view('home', [
            'photos' => $photos,
            'groupedAnnouncements' => $groupedAnnouncements,
            'latestEvent' => $latestEvent,
            'registeredCount' => $registeredCount,
            'availableSpots' => $availableSpots,
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
