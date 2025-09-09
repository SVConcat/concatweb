<?php

namespace App\Providers;

use App\Events\AnnouncementCreated;
use App\Events\EventCreated;
use App\Listeners\SendDiscordWebhookNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AnnouncementCreated::class => [
            SendDiscordWebhookNotification::class,
        ],
        EventCreated::class => [
            SendDiscordWebhookNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
