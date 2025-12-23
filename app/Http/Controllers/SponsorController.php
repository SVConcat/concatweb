<?php

namespace App\Http\Controllers;

use App\Http\Requests\SponsorRequest;
use App\Models\Sponsor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $sponsors = Sponsor::all();
        $inactiveSponsors = Sponsor::onlyTrashed()->get();

        return view('sponsors.index', [
            'sponsors' => $sponsors,
            'inactiveSponsors' => $inactiveSponsors
        ]);
    }

    public function create()
    {
        $this->authorize('create', Sponsor::class);
        return view('sponsors.create');
    }

    public function store(SponsorRequest $request)
    {
        $this->authorize('create', Sponsor::class);

        $imagePath = $request->file('logo')->store('sponsor_logos', 'public');

        $sponsor = Sponsor::create([
            'name' => $request->validated(['name']),
            'description' => $request->validated(['description']),
            'url' => $request->validated(['url']),
            'image_path' => $imagePath
        ]);

        $request['hide'] === 'on' && $sponsor->delete();

        return redirect()
            ->route('sponsors.index');
    }

    public function edit(Sponsor $sponsor)
    {
        $this->authorize('update', $sponsor);
        return view('sponsors.edit', compact('sponsor'));
    }

    public function editHidden($id)
    {
        $sponsor = Sponsor::withTrashed()->findOrFail($id);

        $this->authorize('update', $sponsor);

        return view('sponsors.edit', compact('sponsor'));
    }

    public function update(SponsorRequest $request, $id)
    {
        $sponsor = Sponsor::withTrashed()->findOrFail($id);

        $this->authorize('update', $sponsor);

        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            if ($sponsor->image_path) {
                Storage::disk('public')->delete($sponsor->image_path);
            }

            $validated['image_path'] = $request->file('logo')->store('sponsor_logos', 'public');
        } else {
            $validated['image_path'] = $sponsor->image_path;
        }

        $sponsor->update($validated);

        $request->has('hide')
            ? $sponsor->trashed() || $sponsor->delete()
            : $sponsor->trashed() && $sponsor->restore();

        return redirect()->route('sponsors.index');
    }

    public function destroy(Sponsor $sponsor)
    {
        $this->authorize('delete', $sponsor);

        $sponsor->delete();

        return redirect()
            ->route('sponsors.index');
    }

    public function forceDelete($id)
    {
        $sponsor = Sponsor::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $sponsor);

        Storage::disk('public')->delete($sponsor->image_path);

        $sponsor->forceDelete();

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Sponsor definitief verwijderd.');
    }

    public function restore($id)
    {
        Sponsor::onlyTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Sponsor hersteld.');
    }
}
