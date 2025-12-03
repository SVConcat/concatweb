<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Listeners\Discord\Events\NewEventAdded::class => [
            \App\Listeners\Discord\Events\NotifyDiscordEventChannel::class,
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

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
