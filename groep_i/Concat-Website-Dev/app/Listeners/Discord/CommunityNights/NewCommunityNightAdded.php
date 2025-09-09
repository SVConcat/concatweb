<?php

namespace App\Listeners\Discord\CommunityNights;

use Illuminate\Foundation\Events\Dispatchable;

class NewCommunityNightAdded
{
    use Dispatchable;

    public $title;
    public $description;
    public $startDate;
    public $startTime;
    public $location;
    public $spotsAvailable;
    public $url;
    public $imageUrl;
    public $type;

    public function __construct(string $title, string $description, ?string $startDate, ?string $startTime, ?string $location, ?int $spotsAvailable, string $url, ?string $imageUrl = null)
    {
        $this->title = $title ?? 'Geen titel';
        $this->description = $description ?? 'Geen beschrijving beschikbaar';
        $this->startDate = $startDate ?? 'Datum nog niet bekend';
        $this->startTime = $startTime ?? 'Tijd nog niet bekend';
        $this->location = $location ?? 'Locatie nog niet bekend';
        $this->spotsAvailable = $spotsAvailable === null ? 'Onbeperkt' : (string)$spotsAvailable;
        $this->url = $url;
        $this->imageUrl = $imageUrl;
    }
}
