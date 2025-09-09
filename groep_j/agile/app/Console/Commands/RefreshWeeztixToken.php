<?php

namespace App\Console\Commands;

use App\Services\WeeztixService;
use Illuminate\Console\Command;

class RefreshWeeztixToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-weeztix-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the Weeztix token';

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
    public function handle()
    {
        $this->weeztixService->refreshToken();
        $this->info('Weeztix token refreshed successfully.');
    }
}
