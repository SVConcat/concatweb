<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use App\Services\SearchService;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    protected $announcementService;

    protected $searchService;

    public function __construct(AnnouncementService $announcementService, SearchService $searchService)
    {
        $this->announcementService = $announcementService;
        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        $query = Announcement::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $this->searchService->search($query, $request->search, Announcement::class);
        }

        $announcements = $query->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.form');
    }

    public function store(AnnouncementRequest $request)
    {
        $data = $request->validated();
        $this->announcementService->store($data, $request);

        return redirect()->route('admin.announcements.index');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.form', compact('announcement'));
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $data = $request->validated();
        $this->announcementService->update($announcement, $data, $request);

        return redirect()->route('admin.announcements.index');
    }

    public function delete($id)
    {
        $announcement = Announcement::findOrFail($id);
        $this->announcementService->delete($announcement);

        return redirect()->route('admin.announcements.index');
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('user.announcements.show', ['announcement' => $announcement]);
    }

    public function publicIndex()
    {
        $announcements = $this->announcementService->getPaginatedPublicAnnouncements();
        return view('user.announcements.index', compact('announcements'));
    }

}
