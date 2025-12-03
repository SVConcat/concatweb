<?php

namespace App\Http\Controllers;

use App\Listeners\Discord\CommunityNights\NewCommunityNightAdded;
use App\Models\CommunityNight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CommunityNightController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return view('community-nights.index', [
            'communityNights' => CommunityNight::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    public function create()
    {
        $this->authorize('create', CommunityNight::class);
        return view('community-nights.create');
    }

    public function store(Request $communityNight)
    {
        $this->authorize('create', CommunityNight::class);

        $communityNight->validate([
            'title' => 'required',
            'description' => 'required|min:10',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required'
        ],
            [
                'title.required' => 'Titel is verplicht.',
                'description.required' => 'Beschrijving is verplicht.',
                'description.min' => 'Beschrijving moet minimaal 10 tekens bevatten.',
                'start_time.required' => 'Starttijd is verplicht.',
                'end_time.required' => 'Eindtijd is verplicht.',
                'location.required' => 'Locatie is verplicht.',
            ]);

        $imagePath = null;

        if ($communityNight->hasFile('image')) {
            $imagePath = $communityNight->file('image')->store('community-nights', 'public');
        }

        // Sla de CommunityNight op in een variabele
        $newCommunityNight = CommunityNight::create([
            'title' => $communityNight->input('title'),
            'image' => $imagePath,
            'description' => $communityNight->input('description'),
            'start_time' => $communityNight->input('start_time'),
            'end_time' => $communityNight->input('end_time'),
            'location' => $communityNight->input('location'),
            'link' => $communityNight->input('link'),
            'capacity' => $communityNight->input('capacity')
        ]);

        // In de store method, vervang het event() deel met:
        $imageUrl = null;
        if ($newCommunityNight->image) {
            $imageUrl = asset('storage/' . $newCommunityNight->image);
        }

        // Gebruik de juiste velden van het model
        event(new NewCommunityNightAdded(
            $newCommunityNight->title,
            $newCommunityNight->description,
            $newCommunityNight->start_time ? date('d-m-Y', strtotime($newCommunityNight->start_time)) : null,
            $newCommunityNight->start_time ? date('H:i', strtotime($newCommunityNight->start_time)) : null,
            $newCommunityNight->location ?? null,
            $newCommunityNight->capacity,
            route('community-nights.show', $newCommunityNight->id),
            $imageUrl // Voeg de afbeelding URL toe
        ));

        return redirect()->route('community-nights.index');
    }

    public function show(CommunityNight $communityNight)
    {
        return view('community-nights.detail', ['communityNight' => $communityNight]);
    }

    public function edit(CommunityNight $communityNight)
    {
        $this->authorize('update', $communityNight);
        return view('community-nights.edit', ['communityNight' => $communityNight]);
    }

    public function update(Request $request, CommunityNight $communityNight)
    {

        $this->authorize('update', $communityNight);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required|min:10',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required',
            'link' => 'nullable',
            'capacity' => 'nullable|integer|min:0',

        ],
            [
                'title.required' => 'Titel is verplicht.',
                'description.required' => 'Beschrijving is verplicht.',
                'description.min' => 'Beschrijving moet minimaal 10 tekens bevatten.',
                'start_time.required' => 'Starttijd is verplicht.',
                'end_time.required' => 'Eindtijd is verplicht.',
                'location.required' => 'Locatie is verplicht.',
            ]);


        $communityNight->title = $validated['title'];
        $communityNight->description = $validated['description'];
        $communityNight->start_time = $validated['start_time'];
        $communityNight->end_time = $validated['end_time'];
        $communityNight->location = $validated['location'];
        $communityNight->link = $validated['link'] ?? null;
        $communityNight->capacity = $validated['capacity'] ?? null;

        if ($request->hasFile('image')) {

            if ($communityNight->image) {
                Storage::delete($communityNight->image);
            }

            $imagePath = $request->file('image')->store('community-nights', 'public');

            $communityNight->image = $imagePath;
        }

        $communityNight->save();

        // Redirect naar de detailpagina of een andere gewenste pagina
        return redirect()->route('community-nights.edit', $communityNight->id)
            ->with('success', 'Community avond succesvol bijgewerkt!');

    }

    public function destroy(CommunityNight $communityNight)
    {

        $this->authorize('destroy', $communityNight);
        if ($communityNight->image) {
            Storage::delete($communityNight->image);
        }

        $communityNight->delete();

        return redirect()->route('community-nights.index')
            ->with('success', 'Community Avond succesvol verwijderd.');
    }

    public function latest()
    {
        return CommunityNight::orderBy('created_at', 'desc')->first();
    }
}
