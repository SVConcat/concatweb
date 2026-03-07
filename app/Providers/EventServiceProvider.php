<?php

namespace App\Providers;

use App\Listeners\Discord\Events\NewEventAdded;
use App\Listeners\Discord\Events\NotifyDiscordEventChannel;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewEventAdded::class => [
            NotifyDiscordEventChannel::class,
        ],
        'App\Listeners\Discord\Announcements\NewAnnouncementAdded' => [
            'App\Listeners\Discord\Announcements\NotifyDiscordAnnouncementChannel',
        ],
        'App\Listeners\Discord\CommunityNights\NewCommunityNightAdded' => [
            'App\Listeners\Discord\CommunityNights\NotifyDiscordCommunityNightChannel',
        ],
    ];

    public function boot()
    {
        //
    }

    public function shouldDiscoverEvents(): false
    {
        return false;
    }
}
