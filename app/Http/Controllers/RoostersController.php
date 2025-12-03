<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ICal\ICal;
use App\Models\Rooster;
use Carbon\Carbon;

class RoostersController extends Controller
{
public function index()
{
    $roosters = Rooster::latest()->take(10)->get();
    $events = [];

    $availableColors = ['#e6194b', '#3cb44b', '#ffe119', '#4363d8'];
    $klasColors = [
        1 => $availableColors[0],
        2 => $availableColors[1],
        3 => $availableColors[2],
        4 => $availableColors[3],
    ];

    foreach ($roosters as $rooster) {
        $ical = new \ICal\ICal(null, [
            'defaultSpan' => 2,
            'defaultTimeZone' => 'Europe/Amsterdam',
        ]);

        try {
            $ical->initUrl($rooster->ical_url);
            $color = $klasColors[$rooster->klas] ?? '#999999'; // kleur op basis van klas

            foreach ($ical->events() as $event) {
                $start = Carbon::parse($event->dtstart)->setTimezone('Europe/Amsterdam');
                $end = Carbon::parse($event->dtend)->setTimezone('Europe/Amsterdam');
                $urlParts = parse_url($rooster->ical_url);
                parse_str($urlParts['query'] ?? '', $params);
                $shortName = $params['value'] ?? 'onbekend';

                $events[] = [
                    'title' => $event->summary,
                    'start' => $start->format('d-m-Y H:i'),
                    'end' => $end->format('d-m-Y H:i'),
                    'calendar_name' => $shortName,
                    'color' => $color,
                    'klas' => $rooster->klas,
                ];
            }
        } catch (\Exception $e) {
            // Sla foutieve URL's over
            continue;
        }
    }

    return view('roosters.index', [
        'roosters' => $roosters,
        'events' => $events,
    ]);
}




    public function store(Request $request)
    {
        $validated = $request->validate([
            'ical_url' => 'required|url|unique:roosters,ical_url',
            'klas' => 'required|integer|max:255',

        ], [
            'ical_url.unique' => 'Deze kalender URL is al toegevoegd.',
            'ical_url.url' => 'De kalender URL moet een geldige link zijn.',
          ]);

        Rooster::create([
            'ical_url' => $validated['ical_url'],
            'klas' => $validated['klas'],
        ]);

        return redirect()->back()->with('success', 'Roosterlink opgeslagen!');
    }

    public function destroy(Rooster $rooster)
    {
        try {
            $rooster->delete();
            return redirect()->back()->with('success', 'Rooster verwijderd!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Kon rooster niet verwijderen: ' . $e->getMessage());
        }
    }
    public function getHourlyData(Request $request)
{
    $date = Carbon::parse($request->date)->timezone('Europe/Amsterdam')->toDateString();

    $roosters = Rooster::all();
    $colors = ['#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#46f0f0', '#f032e6', '#bcf60c', '#fabebe'];

    $hourlyCounts = array_fill(0, 24, 0);

    foreach ($roosters as $index => $rooster) {
        $ical = new \ICal\ICal(null, ['defaultSpan' => 2, 'defaultTimeZone' => 'Europe/Amsterdam']);

        try {
            $ical->initUrl($rooster->ical_url);
            foreach ($ical->events() as $event) {
                $start = Carbon::parse($event->dtstart)->setTimezone('Europe/Amsterdam');
                $end = Carbon::parse($event->dtend)->setTimezone('Europe/Amsterdam');

                if ($start->toDateString() === $date) {
                    for ($hour = $start->hour; $hour <= $end->hour; $hour++) {
                        if (isset($hourlyCounts[$hour])) {
                            $hourlyCounts[$hour]++;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            continue;
        }
    }

    return response()->json([
        'labels' => array_map(fn($h) => str_pad($h, 2, '0', STR_PAD_LEFT) . ":00", range(0, 23)),
        'data' => array_values($hourlyCounts),
    ]);
}
public function adminIndex()
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Access denied');
    }

    // admin logic here...
}
}
