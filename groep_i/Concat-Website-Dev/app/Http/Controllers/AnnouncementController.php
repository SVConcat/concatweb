<?php

namespace App\Http\Controllers;

use App\Listeners\Discord\Announcements\NewAnnouncementAdded;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Zichtbare announcements voor iedereen
        $visibleAnnouncements = Announcement::where('isVisible', true)
            ->orderByDesc('published_at')
            ->get();

        $groupedVisible = $this->groupAnnouncements($visibleAnnouncements);

        // Niet-zichtbare alleen voor admins
        $groupedNonVisible = [];
        if(auth()->user() && auth()->user()->isAdmin()) {
            $nonVisibleAnnouncements = Announcement::where('isVisible', false)
                ->orderByDesc('published_at')
                ->get();
            $groupedNonVisible = $this->groupAnnouncements($nonVisibleAnnouncements);
        }

        return view('announcements.index', [
            'groupedVisible' => $groupedVisible,
            'groupedNonVisible' => $groupedNonVisible,
            'showAdminControls' => auth()->user() && auth()->user()->isAdmin()
        ]);
    }
    private function groupAnnouncements($announcements)
    {
        $grouped = [];
        foreach($announcements as $announcement) {
            // Use published_at if available, otherwise fallback to created_at
            $date = $announcement->published_at ?? $announcement->created_at;
            $group = $this->getDateGroup($date);
            $grouped[$group][] = $announcement;
        }
        return $grouped;
    }

    private function getDateGroup($date)
    {
        $now = now();
        $date = $date->copy()->startOfDay();
        $diffInDays = $date->diffInDays($now);

        if($date->isToday()) return 'Vandaag';
        if($date->isYesterday()) return 'Gisteren';
        if($diffInDays <= 7) return 'Deze Week';
        if($diffInDays <= 14) return 'Vorige Week';
        if($date->month == $now->month && $date->year == $now->year) return 'Deze Maand';
        if($date->month == $now->subMonth()->month && $date->year == $now->year) return 'Vorige Maand';

        return $date->translatedFormat('F Y');
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'inhoud' => 'required|string',
        ], [
            'titel.required' => 'Titel is verplicht.',
            'inhoud.required' => 'Inhoud is verplicht.',
        ]);

        // Check which button was clicked
        $isVisible = $request->input('action') === 'publish';

        // Create the announcement with isVisible determined by the button clicked
        $announcement = Announcement::create(array_merge($validated, [
            'isVisible' => $isVisible,
        ]));

        // Automatically set published_at if it's published
        if ($isVisible) {
            event(new NewAnnouncementAdded(
                $announcement->titel,
                $announcement->inhoud,
                route('announcements.index')
            ));

            $announcement->update(['published_at' => now()]);
        }

        return redirect()->route('announcements.index');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'inhoud' => 'required|string',
        ]);

        // Check which button was clicked
        $action = $request->input('action');

        // Handle "Bijwerken" action (announcement is already published)
        if ($action === 'update') {
            $announcement->update($validated);

            return redirect()->route('announcements.index')->with('success', 'Announcement bijgewerkt.');
        }

        // Determine visibility for "save" (draft) or "publish" actions
        $isVisible = $action === 'publish';

        // Check if the announcement was previously a draft and is now published
        $wasDraft = !$announcement->isVisible && $isVisible;

        // Update announcement (visibility and other details)
        $announcement->update(array_merge($validated, [
            'isVisible' => $isVisible,
        ]));

        // If it was a draft and is now being published, set `published_at` and fire the event
        if ($wasDraft) {
            $announcement->update(['published_at' => now()]);

            // Fire the event to notify Discord
            event(new NewAnnouncementAdded(
                $announcement->titel,
                $announcement->inhoud,
                route('announcements.index')
            ));
        }

        return redirect()->route('announcements.index')->with('success', 'Announcement bijgewerkt.');
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Announcement verwijderd.');
    }
}
