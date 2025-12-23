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
        return view('community-nights.index', [
            'communityNights' => CommunityNight::orderBy('created_at', 'desc')->paginate(10)
        ]);
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

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community-nights', 'public');
        }

        $communityNight = CommunityNight::create([
            'title' => $request->validated('title'),
            'image' => $imagePath,
            'description' => $request->validated('description'),
            'start_time' => $request->validated('start_time'),
            'end_time' => $request->validated('end_time'),
            'location' => $request->validated('location'),
            'link' => $request->validated('link'),
            'capacity' => $request->validated('capacity')
        ]);

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

        $communityNight->title = $request->validated('title');
        $communityNight->description = $request->validated('description');
        $communityNight->start_time = $request->validated('start_time');
        $communityNight->end_time = $request->validated('end_time');
        $communityNight->location = $request->validated('location');
        $communityNight->link = $request->validated('link');
        $communityNight->capacity = $request->validated('capacity');

        if ($request->hasFile('image')) {

            if ($communityNight->image) {
                Storage::delete($communityNight->image);
            }

            $imagePath = $request->file('image')->store('community-nights', 'public');

            $communityNight->image = $imagePath;
        }

        $communityNight->save();

        return redirect()
            ->back()
            ->with('success', 'Community avond succesvol bijgewerkt!');
    }

    public function destroy(CommunityNight $communityNight)
    {
        $this->authorize('destroy', $communityNight);

        if ($communityNight->image) {
            Storage::delete($communityNight->image);
        }

        $communityNight->delete();

        return redirect()
            ->route('community-nights.index')
            ->with('success', 'Community Avond succesvol verwijderd.');
    }
}
