<?php

namespace App\Http\Controllers;

use App\Enums\EventCategoryEnum;
use App\Services\EventService;

class HomeController extends Controller
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->getEvents()->whereNot('category', EventCategoryEnum::COMMUNITY->value)->limit(4)->get();
        $homeImages = $this->eventService->getHomeImages();

        return view('home', ['events' => $events, 'homeImages' => $homeImages]);
    }
}
