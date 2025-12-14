<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $photos = $query
            ->orderBy('title')
            ->get();

        return view('gallery.index', compact('photos'));
    }

    public function create()
    {
        $evenementen = Event::orderBy('datum', 'desc')->get();
        return view('gallery.create', compact('evenementen'));
    }

    public function store(GalleryRequest $request)
    {
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('gallery', 'public');

            $photo = Gallery::create([
                'title' => $request->validated(['title']),
                'date' => $request->validated(['date']),
                'type' => $request->validated(['type']),
                'src' => $imagePath,
            ]);

            if ($request->has('evenementen')) {
                $photo->evenementen()->attach($request->evenementen);
            }
        }

        return redirect()->route('gallery.index')->with('success', 'Foto\'s succesvol toegevoegd');
    }

    public function edit(Gallery $gallery)
    {
        $evenementen = Event::orderBy('datum', 'desc')->get();
        return view('gallery.edit', compact('gallery', 'evenementen'));
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $gallery->title = $request->validated(['title']);
        $gallery->date = $request->validated(['date']);
        $gallery->type = $request->validated(['type']);

        if ($request->hasFile('image')) {
            if ($gallery->src) {
                Storage::delete($gallery->src);
            }

            $imagePath = $request->file('image')->store('gallery', 'public');

            $gallery->src = $imagePath;
        }

        $gallery->save();
        $gallery->evenementen()->sync($request->input('evenementen', []));

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Foto bijgewerkt');
    }

    public function destroy(Gallery $photo)
    {
        if ($photo->src) {
            Storage::delete($photo->src);
        }

        $photo->delete();

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Foto succesvol verwijderd.');
    }
}
