<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $photos = $query->get();

        return view('gallery.index', compact('photos'));
    }

    public function create()
    {
        $evenementen = Events::orderBy('datum', 'desc')->get();
        return view('gallery.create', compact('evenementen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:blokborrel,education',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB per bestand
            'evenementen' => 'nullable|array',
            'evenementen.*' => 'exists:events,id',
        ], [
            'title.required' => 'De titel is verplicht.',
            'date.required' => 'De datum is verplicht.',
            'type.required' => 'Het type evenement is verplicht.',
            'images.required' => 'Er moet minimaal één afbeelding worden geüpload.',
            'images.*.image' => 'Alle bestanden moeten geldige afbeeldingen zijn.',
            'images.*.mimes' => 'Afbeeldingen moeten een van de volgende formaten hebben: jpeg, png, jpg, gif.',
            'images.*.max' => 'Elke afbeelding mag niet groter zijn dan 5MB.'
        ]);

        foreach ($request->file('images') as $image) {
            $path = $image->store('gallery', 'public');

            $photo = Gallery::create([
                'title' => $request->title,
                'date' => $request->date,
                'type' => $request->type,
                'src' => 'storage/' . $path,
            ]);

            if ($request->has('evenementen')) {
                $photo->evenementen()->attach($request->evenementen);
            }
        }

        return redirect()->route('gallery.index')->with('success', 'Foto\'s succesvol toegevoegd');
    }

    public function edit(Gallery $gallery)
    {
        $evenementen = Events::orderBy('datum', 'desc')->get();
        return view('gallery.edit', compact('gallery', 'evenementen'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:blokborrel,education',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1000',
            'evenementen' => 'nullable|array',
            'evenementen.*' => 'exists:events,id',
        ], [
            'title.required' => 'De titel is verplicht.',
            'date.required' => 'De datum is verplicht.',
            'type.required' => 'Het type evenement is verplicht.',
            'image.required' => 'De afbeelding is verplicht.',
            'image.image' => 'De afbeelding moet een geldig beeldbestand zijn.',
            'image.mimes' => 'De afbeelding moet een van de volgende formaten hebben: jpeg, png, jpg, gif.',
            'image.max' => 'De afbeelding mag niet groter zijn dan 1MB.'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $gallery->src = 'storage/' . $path;
        }

        $gallery->title = $request->title;
        $gallery->date = $request->date;
        $gallery->type = $request->type;
        $gallery->save();

        // Sync evenementen
        $gallery->evenementen()->sync($request->input('evenementen', []));

        return redirect()->route('gallery.index')->with('success', 'Foto bijgewerkt');
    }

    public function destroy(Gallery $photo)
    {
        // Verwijder eerst de opgeslagen afbeelding uit de storage, als die er is
        if ($photo->src) {
            $path = str_replace('storage/', '', $photo->src);
            \Storage::disk('public')->delete($path);
        }

        $photo->delete();

        return redirect()->route('gallery.index')->with('success', 'Foto succesvol verwijderd.');
    }
}
