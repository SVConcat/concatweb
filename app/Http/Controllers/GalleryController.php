<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Http\Request;
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
        $validated = $request->validated();

        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('gallery', 'public');
            $photo = Gallery::create([
                ...$validated,
                'src' => $imagePath,
            ]);

            if ($request->has('evenementen')) {
                $photo->evenementen()->attach($request->evenementen);
            }
        }

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Foto\'s succesvol toegevoegd');
    }

    public function edit(Gallery $gallery)
    {
        $evenementen = Event::orderBy('datum', 'desc')->get();

        return view('gallery.edit', compact('gallery', 'evenementen'));
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $validated = $request->validated();
        $request->hasFile('image') && $validated['image'] = $gallery->replaceFile($request->file('image'), 'gallery', 'public', 'image');
        $gallery->update($validated);
        $gallery->evenementen()->sync($request->input('evenementen', []));

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Foto bijgewerkt');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->removeFile('public', 'src');
        $gallery->delete();

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Foto succesvol verwijderd.');
    }
}
