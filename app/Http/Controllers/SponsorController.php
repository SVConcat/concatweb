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

    public function store(SponsorRequest $request)
    {
        $validated = $request->validated();
        $request->hasFile('logo') && $validated['logo'] = $request->file('logo')->store('sponsor_logos', 'public');
        $sponsor = Sponsor::create($validated);
        $request['hide'] === 'on' && $sponsor->delete();

        return redirect()->route('sponsors.index');
    }

    public function create()
    {
        return view('sponsors.create');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('sponsors.edit', compact('sponsor'));
    }

    public function editHidden($id)
    {
        $sponsor = Sponsor::withTrashed()->findOrFail($id);

        return view('sponsors.edit', compact('sponsor'));
    }

    public function update(SponsorRequest $request, $id)
    {
        $sponsor = Sponsor::withTrashed()->findOrFail($id);

        $validated = $request->validated();
        $request->hasFile('logo') && $validated['logo'] = $sponsor->replaceFile($request->file('logo'), 'sponsor_logos', 'public', 'logo');
        $sponsor->update($validated);
        $request->has('hide')
            ? $sponsor->trashed() || $sponsor->delete()
            : $sponsor->trashed() && $sponsor->restore();

        return redirect()->route('sponsors.index');
    }

    public function restore($id)
    {
        Sponsor::onlyTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Sponsor hersteld.');
    }

    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();

        return redirect()
            ->route('sponsors.index');
    }

    public function forceDelete($id)
    {
        $sponsor = Sponsor::onlyTrashed()->findOrFail($id);
        $sponsor->image_path && Storage::disk('public')->delete($sponsor->image_path);
        $sponsor->forceDelete();

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Sponsor definitief verwijderd.');
    }
}
