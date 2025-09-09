<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class NewsletterController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $published = Newsletter::whereDate('publicatiedatum', '<=', $today)
            ->orderByDesc('publicatiedatum')
            ->paginate(6);

        $upcoming = [];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $upcoming = Newsletter::whereDate('publicatiedatum', '>', $today)
                ->orderBy('publicatiedatum')
                ->get();
        }

        return view('newsletters.index', compact('published', 'upcoming'));
    }

    public function show(Newsletter $newsletter)
    {
        $events = $newsletter->inhoud;
        $images = $newsletter->images ?? [];
        return view('newsletters.show', compact('newsletter', 'events', 'images'));
    }

    public function create()
    {
        return view('newsletters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255|unique:newsletters,titel',
            'publicatiedatum' => 'required|date',
            'events' => 'required|array|min:1',
            'events.*.titel' => 'required|string',
            'events.*.datum' => 'nullable|date',
            'events.*.tijd' => 'nullable|string',
            'events.*.locatie' => 'nullable|string',
            'events.*.inhoud' => 'required|string',
            'event_images.*' => 'image|max:1000',
        ], [
            'titel.required' => 'De titel van de nieuwsbrief is verplicht.',
            'publicatiedatum.required' => 'De publicatiedatum van de nieuwsbrief is verplicht.',
            'events.required' => 'Er moet ten minste één evenement worden toegevoegd.',
            'events.*.titel.required' => 'De titel van elk evenement is verplicht.',
            'events.*.inhoud.required' => 'De inhoud van elk evenement is verplicht.',
            'event_images.*.image' => 'Alle geüploade bestanden moeten afbeeldingen zijn.',
            'event_images.*.max' => 'Elke afbeelding mag maximaal 1 MB zijn.',
        ]);

        $imagePaths = [];
        if ($request->hasFile('event_images')) {
            foreach ($request->file('event_images') as $image) {
                $path = $image->store('newsletters/images', 'public');
                $imagePaths[] = 'storage/' . $path;
            }
        }

        $formattedDate = Carbon::parse($validated['publicatiedatum'])->format('d-m-Y');

        $formattedEvents = collect($validated['events'])->map(function ($event) {
            return [
                'titel' => $event['titel'],
                'datum' => $event['datum'] ? Carbon::parse($event['datum'])->format('d-m-Y') : null,
                'tijd' => $event['tijd'] ?? '',
                'locatie' => $event['locatie'] ?? '',
                'inhoud' => $event['inhoud'],
            ];
        })->toArray();

        $pdf = Pdf::loadView('newsletters.pdf', [
            'title' => $validated['titel'],
            'publicatiedatum' => $formattedDate,
            'events' => $formattedEvents,
            'images' => $imagePaths,
        ]);

        $filename = Str::slug($validated['titel']) . '-' . time() . '.pdf';
        $pdfPath = 'newsletters/' . $filename;
        Storage::disk('public')->put($pdfPath, $pdf->output());

        Newsletter::create([
            'titel' => $validated['titel'],
            'publicatiedatum' => Carbon::parse($validated['publicatiedatum']),
            'inhoud' => $validated['events'],
            'pdf' => $pdfPath,
            'images' => $imagePaths,
        ]);

        return redirect()->route('newsletters.index')
            ->with('success', 'Nieuwsbrief succesvol aangemaakt en PDF gegenereerd.');
    }

    public function edit(Newsletter $newsletter)
    {
        $events = $newsletter->inhoud;
        return view('newsletters.edit', compact('newsletter', 'events'));
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255|unique:newsletters,titel,' . $newsletter->id,
            'publicatiedatum' => 'required|date',
            'events' => 'required|array|min:1',
            'events.*.titel' => 'required|string',
            'events.*.datum' => 'nullable|date',
            'events.*.tijd' => 'nullable|string',
            'events.*.locatie' => 'nullable|string',
            'events.*.inhoud' => 'required|string',
            'event_images.*' => 'image|max:1000',
        ], [
            'titel.required' => 'De titel van de nieuwsbrief is verplicht.',
            'publicatiedatum.required' => 'De publicatiedatum van de nieuwsbrief is verplicht.',
            'events.required' => 'Er moet ten minste één evenement worden toegevoegd.',
            'events.*.titel.required' => 'De titel van elk evenement is verplicht.',
            'events.*.inhoud.required' => 'De inhoud van elk evenement is verplicht.',
            'event_images.*.image' => 'Alle geüploade bestanden moeten afbeeldingen zijn.',
            'event_images.*.max' => 'Elke afbeelding mag maximaal 1 MB zijn.',
        ]);

        $imagePaths = $newsletter->images ?? [];

        if ($request->hasFile('event_images')) {
            foreach ($request->file('event_images') as $image) {
                $path = $image->store('newsletters/images', 'public');
                $imagePaths[] = 'storage/' . $path;
            }
        }

        $formattedDate = Carbon::parse($validated['publicatiedatum'])->format('d-m-Y');

        $formattedEvents = collect($validated['events'])->map(function ($event) {
            return [
                'titel' => $event['titel'],
                'datum' => $event['datum'] ? Carbon::parse($event['datum'])->format('d-m-Y') : null,
                'tijd' => $event['tijd'] ?? '',
                'locatie' => $event['locatie'] ?? '',
                'inhoud' => $event['inhoud'],
            ];
        })->toArray();

        $pdf = Pdf::loadView('newsletters.pdf', [
            'title' => $validated['titel'],
            'publicatiedatum' => $formattedDate,
            'events' => $formattedEvents,
            'images' => $imagePaths,
        ]);

        $filename = Str::slug($validated['titel']) . '-' . time() . '.pdf';
        $pdfPath = 'newsletters/' . $filename;
        Storage::disk('public')->put($pdfPath, $pdf->output());

        $newsletter->update([
            'titel' => $validated['titel'],
            'publicatiedatum' => Carbon::parse($validated['publicatiedatum']),
            'inhoud' => $validated['events'],
            'pdf' => $pdfPath,
            'images' => $imagePaths,
        ]);

        return redirect()->route('newsletters.index')
            ->with('success', 'Nieuwsbrief succesvol bijgewerkt.');
    }
}
