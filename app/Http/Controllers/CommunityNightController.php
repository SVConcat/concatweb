<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityNightRequest;
use App\Listeners\Discord\CommunityNights\NewCommunityNightAdded;
use App\Models\CommunityNight;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;


class CommunityNightController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $communityNights = CommunityNight::orderBy('created_at', 'desc')->paginate(10);

        return view('community-nights.index', compact('communityNights'));
    }

    public function show(CommunityNight $communityNight)
    {
        return view('community-nights.detail', compact('communityNight'));
    }

    public function create()
    {
        $this->authorize('create', CommunityNight::class);

        return view('community-nights.create');
    }

    public function store(CommunityNightRequest $request)
    {
        $this->authorize('create', CommunityNight::class);

        $validated = $request->validated();
        $request->hasFile('image') && $validated['image'] = $request->file('image')->store('community-nights', 'public');
        $communityNight = CommunityNight::create($validated);
        $imageUrl = null;

        if ($communityNight->image) {
            $imageUrl = Storage::url($communityNight->image);
        }

        // Fire the event to notify Discord
        event(new NewCommunityNightAdded(
            $communityNight->title,
            $communityNight->description,
            $communityNight->discord_start_date,
            $communityNight->discord_start_time,
            $communityNight->location,
            $communityNight->capacity,
            route('community-nights.show', $communityNight->id),
            $imageUrl
        ));

        return redirect()
            ->route('community-nights.index')
            ->with('success', 'Community avond succesvol aangemaakt!');
    }

    public function edit(CommunityNight $communityNight)
    {
        $this->authorize('update', $communityNight);

        return view('community-nights.edit', compact('communityNight'));
    }

    public function update(CommunityNightRequest $request, CommunityNight $communityNight)
    {
        $this->authorize('update', $communityNight);

        $validated = $request->validated();
        $request->hasFile('image') && $validated['image'] = $communityNight->replaceFile($request->file('image'), 'community-nights', 'public', 'image');
        $communityNight->update($validated);

        return redirect()
            ->route('community-nights.index')
            ->with('success', 'Community avond succesvol bijgewerkt!');
    }

    public function destroy(CommunityNight $communityNight)
    {
        $this->authorize('destroy', $communityNight);

        $communityNight->image && Storage::delete($communityNight->image);
        $communityNight->delete();

        return redirect()
            ->route('community-nights.index')
            ->with('success', 'Community Avond succesvol verwijderd.');
    }
}
