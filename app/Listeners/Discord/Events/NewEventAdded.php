<?php

namespace App\Listeners\Discord\Events;

use Illuminate\Foundation\Events\Dispatchable;

class NewEventAdded
{
    use Dispatchable;

    public string $title;
    public string $description;
    public string $startDate;
    public string $startTime;
    public string $location;
    public string $spotsAvailable;
    public string $url;
    public ?string $imageUrl;
    public string $type;

    public function __construct(string $title, string $description, ?string $startDate, ?string $startTime, ?string $location, ?int $spotsAvailable, string $url, ?string $imageUrl = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $startDate ?? 'Datum nog niet bekend';
        $this->startTime = $startTime ?? 'Tijd nog niet bekend';
        $this->location = $location;
        $this->spotsAvailable = $spotsAvailable === null ? 'Onbeperkt' : (string)$spotsAvailable;
        $this->url = $url;
        $this->imageUrl = $imageUrl;
        $this->type = 'event';
    }
}
