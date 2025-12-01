<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Listeners\Discord\Events\NewEventAdded;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $validSortOrders = ['asc', 'desc'];
        $sortOrder = $request->query('sort', 'asc');
        $categorieFilter = $request->query('categorie', 'all');

        $isAfgelopen = $request->query('afgelopen') === 'true';


        $onlyMyEvents = $request->query('myevents', false);

        if (!in_array($sortOrder, $validSortOrders)) {
            $sortOrder = 'asc';
        }

        $query = Event::whereNotNull('titel')->where('titel', '!=', '')
            ->whereNotNull('datum')
            ->whereNotNull('einddatum')
            ->whereNotNull('starttijd')
            ->whereNotNull('eindtijd')
            ->whereNotNull('beschrijving')->where('beschrijving', '!=', '')
            ->whereNotNull('locatie')->where('locatie', '!=', '');

        if (in_array($categorieFilter, ['blokborrel', 'education'])) {
            $query->where('categorie', $categorieFilter);
        }


        if ($isAfgelopen) {
            $query->whereDate('einddatum', '<', Carbon::today());

        } else {
            $query->whereDate('einddatum', '>=', Carbon::today());
        }

        if ($onlyMyEvents && auth()->check()) {
            $query->whereHas('registrations', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }
        $events = $query->orderBy('datum', $sortOrder)
            ->orderBy('starttijd', $sortOrder)
            ->paginate(6);

        return view('events/index', compact('events', 'sortOrder', 'categorieFilter', 'onlyMyEvents'));
    }

    public function show(Event $event)
    {
        $registeredCount = $event->registrations()->count();
        $availableSpots = $event->aantal_beschikbare_plekken;

        if (is_null($availableSpots)) {
            $availableSpots = 0;
        }

        return view('events.detail', [
            'event' => $event,
            'registeredCount' => $registeredCount,
            'availableSpots' => $availableSpots
        ]);

    }

    public function create()
    {
        return view('events.create');
    }

    public function store(EventRequest $request)
    {
        $afbeeldingPath = null;

        if ($request->hasFile('afbeelding')) {
            $afbeeldingPath = $request->file('afbeelding')->store('event_images', 'public');
        }

        $event = Event::create([
            'titel' => $request->validated('titel'),
            'categorie' => $request->validated('categorie'),
            'datum' => $request->validated('datum'),
            'einddatum' => $request->validated('einddatum'),
            'starttijd' => $request->validated('starttijd'),
            'eindtijd' => $request->validated('eindtijd'),
            'beschrijving' => $request->validated('beschrijving'),
            'locatie' => $request->validated('locatie'),
            'aantal_beschikbare_plekken' => $request->validated('aantal_beschikbare_plekken'),
            'betaal_link' => $request->validated('betaal_link'),
            'afbeelding' => $afbeeldingPath
        ]);

        $afbeeldingUrl = null;

        if ($event->afbeelding) {
            $afbeeldingUrl = Storage::url($event->afbeelding);
        }

        // Fire the event to notify Discord
        event(new NewEventAdded(
            $event->titel,
            $event->beschrijving,
            $event->datum,
            $event->starttijd,
            $event->locatie,
            $event->aantal_beschikbare_plekken,
            route('events.show', $event->id),
            $afbeeldingUrl
        ));

        return redirect()
            ->route('events.index')
            ->with('success', 'Event succesvol toegevoegd!');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->titel = $request->validated('titel');
        $event->categorie = $request->validated('categorie');
        $event->datum = $request->validated('datum');
        $event->einddatum = $request->validated('einddatum');
        $event->starttijd = $request->validated('starttijd');
        $event->eindtijd = $request->validated('eindtijd');
        $event->beschrijving = $request->validated('beschrijving');
        $event->locatie = $request->validated('locatie');
        $event->aantal_beschikbare_plekken = $request->validated('aantal_beschikbare_plekken');
        $event->betaal_link = $request->validated('betaal_link');

        if ($request->hasFile('image')) {

            if ($event->afbeelding) {
                Storage::delete($event->afbeelding);
            }

            $afbeeldingPath = $request->file('afbeelding')->store('community-nights', 'public');

            $event->afbeelding = $afbeeldingPath;
        }

        $event->save();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event bijgewerkt!');
    }

    public function latest()
    {
        $event = Event::orderBy('created_at', 'desc')->first();

        if (!$event) {
            return [
                'event' => null,
                'registeredCount' => 0,
                'availableSpots' => 0
            ];
        }

        $registeredCount = $event->registrations()->count();
        $availableSpots = $event->aantal_beschikbare_plekken ?? 0;

        return [
            'event' => $event,
            'registeredCount' => $registeredCount,
            'availableSpots' => $availableSpots
        ];
    }

    public function downloadIcs(Event $event)
    {

        $startDateTime = Carbon::parse($event->datum . ' ' . $event->starttijd);
        $endDateTime = Carbon::parse($event->einddatum . ' ' . $event->eindtijd);
        $dtstamp = optional($event->created_at)->format('Ymd\THis\Z') ?? now()->format('Ymd\THis\Z');

        // Escape function to sanitize ICS text fields
        function escapeIcsText($text)
        {
            return addcslashes($text, ",;\\\n\r");
        }

        $summary = escapeIcsText($event->titel ?? '');
        $description = escapeIcsText($event->beschrijving ?? '');
        $location = escapeIcsText($event->locatie ?? '');

        $content = <<<ICS
            BEGIN:VCALENDAR
            VERSION:2.0
            PRODID:-//YourApp//Rooster Calendar//NL
            BEGIN:VEVENT
            UID:{$event->id}@yourapp.com
            DTSTAMP:$dtstamp
            DTSTART:{$startDateTime->format('Ymd\THis')}
            DTEND:{$endDateTime->format('Ymd\THis')}
            SUMMARY:{$summary}
            DESCRIPTION:{$description}
            LOCATION:{$location}
            END:VEVENT
            END:VCALENDAR
        ICS;

        return response($content, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="evenement-' . $event->id . '.ics"',
        ]);
    }

    public function DownloadAllICS()
    {
        $events = Event::all();

        $icalContent = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//YourApp//Event Calendar//EN\r\n";

        foreach ($events as $event) {
            $startDateTime = Carbon::parse($event->datum . ' ' . $event->starttijd);
            $endDateTime = Carbon::parse($event->einddatum . ' ' . $event->eindtijd);
            $dtstamp = optional($event->created_at)->format('Ymd\THis\Z') ?? now()->format('Ymd\THis\Z');

            $summary = addcslashes($event->titel ?? '', ",;\\\n\r");
            $description = addcslashes($event->beschrijving ?? '', ",;\\\n\r");
            $location = addcslashes($event->locatie ?? '', ",;\\\n\r");

            $icalContent .= "BEGIN:VEVENT\r\n";
            $icalContent .= "UID:{$event->id}@yourapp.com\r\n";
            $icalContent .= "DTSTAMP:$dtstamp\r\n";
            $icalContent .= "DTSTART:{$startDateTime->format('Ymd\THis')}\r\n";
            $icalContent .= "DTEND:{$endDateTime->format('Ymd\THis')}\r\n";
            $icalContent .= "SUMMARY:$summary\r\n";
            $icalContent .= "DESCRIPTION:$description\r\n";
            $icalContent .= "LOCATION:$location\r\n";
            $icalContent .= "END:VEVENT\r\n";
        }

        $icalContent .= "END:VCALENDAR\r\n";

        return response($icalContent)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="alle-evenementen.ics"');
    }

    public function destroy(Event $event)
    {
        if ($event->afbeelding) {
            Storage::delete($event->afbeelding);
        }

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event succesvol verwijderd!');
    }
}
