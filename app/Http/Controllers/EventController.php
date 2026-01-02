<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Listeners\Discord\Events\NewEventAdded;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as IcsEvent;

class EventController extends Controller
{
    public function index(Request $request)
    {
        //TODO: FYI, the sort order param currently does not get along the request. It's just defaulting to asc.
        $sortOrder = $request->query('sort');
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

        $categorieFilter = $request->query('categorie', 'all');
        $isAfgelopen = $request->query('afgelopen') === 'true';
        $onlyMyEvents = $request->query('myevents', false);

        $query = Event::query();

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

        $events = $query
            ->orderBy('datum', $sortOrder)
            ->orderBy('starttijd', $sortOrder)
            ->paginate(6);

        return view('events.index', compact('events', 'sortOrder', 'categorieFilter', 'onlyMyEvents'));
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
        $validated = $request->validated();
        $request->hasFile('afbeelding') && $validated['afbeelding'] = $request->file('afbeelding')->store('event_images', 'public');
        $event = Event::create($validated);
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
        $validated = $request->validated();
        $request->hasFile('afbeelding') && $validated['afbeelding'] = $event->replaceFile($request->file('afbeelding'), 'event_images', 'public', 'afbeelding');
        $event->update($validated);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event bijgewerkt!');
    }

    public function downloadIcs(Event $event)
    {
        $domain = parse_url(config('app.url'), PHP_URL_HOST);
        $calendar = Calendar::create(config('app.name'))->event(
            IcsEvent::create($event->titel)
                ->startsAt(Carbon::parse($event->datum . ' ' . $event->starttijd))
                ->endsAt(Carbon::parse($event->einddatum . ' ' . $event->eindtijd))
                ->description($event->beschrijving)
                ->address($event->locatie)
                ->uniqueIdentifier($event->id . '@' . $domain)
        );

        return response(
            $calendar->get(), 200,
            [
                'Content-Type' => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="evenement-' . $event->id . '.ics"',
            ]
        );
    }

    public function downloadAllIcs()
    {
        $calendar = Calendar::create(config('app.name'));
        $domain = parse_url(config('app.url'), PHP_URL_HOST);

        Event::each(function (Event $event) use ($domain, $calendar) {
            $calendar->event(
                IcsEvent::create($event->titel)
                    ->startsAt(Carbon::parse($event->datum . ' ' . $event->starttijd))
                    ->endsAt(Carbon::parse($event->einddatum . ' ' . $event->eindtijd))
                    ->description($event->beschrijving)
                    ->address($event->locatie)
                    ->uniqueIdentifier($event->id . '@' . $domain)
            );
        });

        return response(
            $calendar->get(), 200,
            [
                'Content-Type' => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="alle-evenementen.ics"',
            ]
        );
    }

    public function destroy(Event $event)
    {
        $event->afbeelding && Storage::delete($event->afbeelding);
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event succesvol verwijderd!');
    }
}
