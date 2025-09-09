<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;

class GoogleCalendarService
{
    public function createEvent(string $startDate, string $endDate, string $title, string $category, int $eventId)
    {
        $event = new \Spatie\GoogleCalendar\Event();
        $event->name = $title;
        $event->description = $category;
        $event->startDateTime = Carbon::parse($startDate);
        $event->endDateTime = Carbon::parse($endDate);
        $savedEvent = $event->save();

        Event::where('id', $eventId)->update([
            'google_calendar_event_id' => $savedEvent->id,
        ]);
    }

    public function updateEvent(string $startDate, string $endDate, string $title, string $category, int $eventId)
    {
        $event = Event::where('id', $eventId)->first();

        if (!$event || !$event->google_calendar_event_id) {
            throw new \Exception('Event not found or missing Google Calendar Event ID.');
        }

        $googleEvent = \Spatie\GoogleCalendar\Event::find($event->google_calendar_event_id);

        if (!$googleEvent) {
            throw new \Exception('Google Calendar Event not found.');
        }

        $googleEvent->name = $title;
        $googleEvent->description = $category;
        $googleEvent->startDateTime = Carbon::parse($startDate);
        $googleEvent->endDateTime = Carbon::parse($endDate);
        $googleEvent->save();
    }
}
