<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Listeners\Discord\Announcements\NewAnnouncementAdded;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Visible announcements for all users
        $visibleAnnouncements = Announcement::where('isVisible', true)->orderByDesc('published_at')->get();
        $groupedVisible = $this->groupAnnouncements($visibleAnnouncements);

        // Not visible announcements for admin users only
        $groupedNonVisible = [];

        if (auth()->user() && auth()->user()->isAdmin()) {
            $nonVisibleAnnouncements = Announcement::where('isVisible', false)->orderByDesc('published_at')->get();
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

        foreach ($announcements as $announcement) {
            $date = $announcement->published_at ?? $announcement->created_at;
            $group = $this->getDateGroup($date);
            $grouped[$group][] = $announcement;
        }

        return $grouped;
    }

    private function getDateGroup($date)
    {
        $date = $date->copy()->startOfDay();
        $diffInDays = $date->diffInDays(now());

        if ($date->isToday()) return 'Vandaag';
        elseif ($date->isYesterday()) return 'Gisteren';
        elseif ($diffInDays <= 7) return 'Deze Week';
        elseif ($diffInDays <= 14) return 'Vorige Week';
        elseif ($date->month == now()->month && $date->year == now()->year) return 'Deze Maand';
        elseif ($date->month == now()->subMonth()->month && $date->year == now()->year) return 'Vorige Maand';

        return $date->translatedFormat('F Y');
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(AnnouncementRequest $request)
    {
        $isVisible = $request->input('action') === 'publish';
        $announcement = Announcement::create([...$request->validated(), 'isVisible' => $isVisible,]);

        if ($isVisible) {
            // Fire the event to notify Discord
            event(new NewAnnouncementAdded(
                $announcement->titel,
                $announcement->inhoud,
                route('announcements.index')
            ));

            $announcement->update(['published_at' => now()]);
        }

        return redirect()->route('announcements.index');
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $action = $request->input('action');

        if ($action === 'update') {
            $announcement->update($request->validated());

            return redirect()
                ->route('announcements.index')
                ->with('success', 'Announcement bijgewerkt.');
        }

        $isVisible = $action === 'publish';
        $wasDraft = !$announcement->isVisible && $isVisible;
        $announcement->update([...$request->validated(), 'isVisible' => $isVisible,]);

        if ($wasDraft) {
            $announcement->update(['published_at' => now()]);

            // Fire the event to notify Discord
            event(new NewAnnouncementAdded(
                $announcement->titel,
                $announcement->inhoud,
                route('announcements.index')
            ));
        }

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement bijgewerkt.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement verwijderd.');
    }
}
