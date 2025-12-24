<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterCreateRequest;
use App\Http\Requests\NewsletterUpdateRequest;
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

    public function create()
    {
        return view('newsletters.create');
    }

    public function store(NewsletterCreateRequest $request)
    {
        $imagePaths = [];

        if ($request->hasFile('event_images')) {
            foreach ($request->file('event_images') as $image) {
                $imagePath = $image->store('newsletters/images', 'public');
                $imagePaths[] = $imagePath;
            }
        }

        $events = collect($request->validated('events'))->map(function ($event) {
            return [
                'titel' => $event['titel'],
                'datum' => $event['datum'],
                'tijd' => $event['tijd'],
                'locatie' => $event['locatie'],
                'inhoud' => $event['inhoud'],
            ];
        })->toArray();

        $formattedDate = Carbon::parse($request->validated('publicatiedatum'))->format('d-m-Y');
        $pdf = Pdf::loadView('newsletters.pdf', [
            'title' => $request->validated(['titel']),
            'publicatiedatum' => $formattedDate,
            'events' => $events,
            'images' => $imagePaths,
        ]);

        $filename = Str::slug($request->validated('titel')) . '-' . time() . '.pdf';
        $pdfPath = 'newsletters/' . $filename;

        Storage::disk('public')->put($pdfPath, $pdf->output());

        Newsletter::create([
            'titel' => $request->validated(['titel']),
            'publicatiedatum' => Carbon::parse($request->validated('publicatiedatum')),
            'inhoud' => $request->validated('events'),
            'pdf' => $pdfPath,
            'images' => $imagePaths,
        ]);

        return redirect()
            ->route('newsletters.index')
            ->with('success', 'Nieuwsbrief succesvol aangemaakt en PDF gegenereerd.');
    }

    public function edit(Newsletter $newsletter)
    {
        $events = $newsletter->inhoud;

        return view('newsletters.edit', compact('newsletter', 'events'));
    }

    public function update(NewsletterUpdateRequest $request, Newsletter $newsletter)
    {
        $imagePaths = $newsletter->images;

        if ($request->hasFile('event_images')) {
            foreach ($request->file('event_images') as $image) {
                $imagePath = $image->store('newsletters/images', 'public');
                $imagePaths[] = $imagePath;
            }
        }

        $formattedEvents = collect($request->validated('events'))->map(function ($event) {
            return [
                'titel' => $event['titel'],
                'datum' => $event['datum'],
                'tijd' => $event['tijd'],
                'locatie' => $event['locatie'],
                'inhoud' => $event['inhoud'],
            ];
        })->toArray();

        $formattedDate = Carbon::parse($request->validated('publicatiedatum'))->format('d-m-Y');
        $pdf = Pdf::loadView('newsletters.pdf', [
            'title' => $request->validated(['title']),
            'publicatiedatum' => $formattedDate,
            'events' => $formattedEvents,
            'images' => $imagePaths,
        ]);

        $filename = Str::slug($request->validated(['titel'])) . '-' . time() . '.pdf';
        $pdfPath = 'newsletters/' . $filename;

        Storage::disk('public')->put($pdfPath, $pdf->output());

        $newsletter->update([
            'titel' => $request->validated(['titel']),
            'publicatiedatum' => Carbon::parse($request->validated(['publicatiedatum'])),
            'inhoud' => $request->validated(['events']),
            'pdf' => $pdfPath,
            'images' => $imagePaths,
        ]);

        return redirect()
            ->route('newsletters.index')
            ->with('success', 'Nieuwsbrief succesvol bijgewerkt.');
    }
}
