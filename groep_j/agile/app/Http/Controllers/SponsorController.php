<?php

namespace App\Http\Controllers;

use App\Http\Requests\SponsorRequest;
use App\Services\EventService;
use App\Services\SponsorService;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    private SponsorService $sponsorService;
    private EventService $eventService;
    private $types = ['active' => 'active', 'inactive' => 'inactive'];

    public function __construct(SponsorService $sponsorService, EventService $eventService)
    {
        $this->sponsorService = $sponsorService;
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
       $sponsors = $this->sponsorService->getSponsors();

        if ($request->route()->named('admin.sponsors.index')) {
            $sponsors = $sponsors->paginate(10);
            return view('admin.sponsors.index', ['sponsors' => $sponsors, 'types' => $this->types]);
        }

        $sponsorsUser = $sponsors->where('active', 'active')->paginate(10);
        return view('user.sponsors.index', ['sponsors' => $sponsorsUser, 'types' => $this->types]);
    }

    public function create()
    {
        $events = $this->eventService->getEvents()->get();
        return view('admin.sponsors.show', ['types' => $this->types, 'events' => $events]);
    }

    public function store(SponsorRequest $request)
    {
        $this->sponsorService->storeSponsor($request);
        return to_route('admin.sponsors.index');
    }

    public function show($id)
    {
        $sponsor = $this->sponsorService->getSponsor($id);
        $events = $this->eventService->getEvents()->get();
        return view('admin.sponsors.show', ['sponsor' => $sponsor, 'types' => $this->types, 'events' => $events]);
    }

    public function update(SponsorRequest $request, $id)
    {
        $this->sponsorService->updateSponsor($request, $id);
        return to_route('admin.sponsors.index');
    }

    public function delete($id)
    {
        $this->sponsorService->deleteSponsor($id);
        return to_route('admin.sponsors.index');
    }
}
