<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->startOfDay();

        $query = Event::query()->where('status', 'active')->where('start_date', '>=', $today)->orderBy('start_date', 'ASC');

        if ($request->has('status') && $request->status === 'my_events' && auth()->check()) {
            $query->whereHas('registeredUsers', function ($q) {
                $q->where('user_id', auth()->id());
            });
            $user = auth()->user()->id;
        }

        $events = $query->get()->groupBy(function ($event) {
            return $event->start_date->format('F');
        });

        return view('user.calender.index', ['events' => $events, 'user' => $user ?? null]);
    }

    public function generateICS(Request $request, $id = null)
    {
        $query = Event::query()->where('status', 'active');

        if ($request->has('status') && $request->status === 'my_events' && auth()->check()) {
            $query->whereHas('registeredUsers', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        if($id) {
            $query->whereHas('registeredUsers', function ($q) use ($id) {
                $q->where('user_id', $id);
            });
        }

        $events = $query->get();
        $icsContent = $this->generateICSContent($events);

        return response($icsContent, 200)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="svconcat-calendar.ics"');
    }

    private function generateICSContent($events)
    {
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//" . request()->getHost() . "//NONSGML v1.0//EN\r\n";

        foreach ($events as $event) {
            if ($event->start_date) {
                $ics .= "BEGIN:VEVENT\r\n";
                $ics .= "UID:" . uniqid() . "@" . request()->getHost() . "\r\n";
                $ics .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
                $ics .= "DTSTART:" . $event->start_date->format('Ymd\THis\Z') . "\r\n";
                $ics .= "DTEND:" . ($event->end_date ? $event->end_date->format('Ymd\THis\Z') : $event->start_date->addHour()->format('Ymd\THis\Z')) . "\r\n";
                $ics .= "SUMMARY:" . addslashes($event->title) . "\r\n";
                $ics .= "DESCRIPTION:" . addslashes($event->description) . "\r\n";
                $ics .= "END:VEVENT\r\n";
            }
        }

        $ics .= "END:VCALENDAR\r\n";

        return $ics;
    }
}
