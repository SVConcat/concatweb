<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoosterRequest;
use Exception;
use ICal\ICal;
use App\Models\Rooster;
use Carbon\Carbon;

class RoosterController extends Controller
{
    public function index()
    {
        $roosters = Rooster::latest()->take(10)->get();
        $events = $this->getEventsFromRoosters($roosters);

        return view('roosters.index', compact('roosters', 'events'));
    }

    protected function getEventsFromRoosters($roosters): array
    {
        $events = [];

        $availableColors = ['#e6194b', '#3cb44b', '#ffe119', '#4363d8'];
        $klasColors = [
            1 => $availableColors[0],
            2 => $availableColors[1],
            3 => $availableColors[2],
            4 => $availableColors[3],
        ];

        foreach ($roosters as $rooster) {
            try {
                $ical = new ICal(null, [
                    'defaultSpan' => 2,
                    'defaultTimeZone' => 'Europe/Amsterdam',
                ]);

                $ical->initUrl($rooster->ical_url);

                $color = $klasColors[$rooster->klas] ?? '#999999';
                $calendarName = $this->getCalendarShortName($rooster->ical_url);

                foreach ($ical->events() as $event) {
                    $events[] = $this->formatEvent($event, $color, $rooster->klas, $calendarName);
                }
            } catch (Exception) {
                continue;
            }
        }

        return $events;
    }

    protected function formatEvent($event, string $color, int $klas, string $calendarName): array
    {
        $start = Carbon::parse($event->dtstart)->setTimezone('Europe/Amsterdam');
        $end = Carbon::parse($event->dtend)->setTimezone('Europe/Amsterdam');

        return [
            'title' => $event->summary,
            'start' => $start->format('d-m-Y H:i'),
            'end' => $end->format('d-m-Y H:i'),
            'calendar_name' => $calendarName,
            'color' => $color,
            'klas' => $klas,
        ];
    }

    protected function getCalendarShortName(string $icalUrl): string
    {
        $urlParts = parse_url($icalUrl);

        parse_str($urlParts['query'] ?? '', $params);

        return $params['value'] ?? 'onbekend';
    }

    public function store(RoosterRequest $request)
    {
        Rooster::create($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Roosterlink opgeslagen!');
    }

    public function destroy(Rooster $rooster)
    {
        $rooster->delete();

        return redirect()
            ->back()
            ->with('success', 'Rooster verwijderd!');
    }
}
