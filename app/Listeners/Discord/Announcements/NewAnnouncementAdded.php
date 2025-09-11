<?php

namespace App\Listeners\Discord\Announcements;

use Illuminate\Foundation\Events\Dispatchable;

class NewAnnouncementAdded
{
    use Dispatchable;

    public $title;
    public $description;
    public $url;
    public $type;

    public function __construct(string $title, string $description, string $url = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->type = 'announcement';
    }
}
