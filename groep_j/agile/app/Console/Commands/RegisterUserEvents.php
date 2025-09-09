<?php

namespace App\Console\Commands;

use App\Services\WeeztixService;
use Illuminate\Console\Command;

class RegisterUserEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register-user-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register user events';

    private WeeztixService $weeztixService;

    /**
     * Create a new command instance.
     *
     * @param WeeztixService $weeztixService
     */
    public function __construct(WeeztixService $weeztixService)
    {
        parent::__construct();
        $this->weeztixService = $weeztixService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = $this->weeztixService->getEvents();

        foreach ($events as $guid => $name) {
            $this->weeztixService->registerUserEvent($guid);
        }
        $this->info('User events registered successfully.');
    }
}
