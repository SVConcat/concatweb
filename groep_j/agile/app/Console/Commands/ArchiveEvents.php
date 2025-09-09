<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArchiveEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:archive-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive events that are older than today.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!DB::table('events')->where('status', 'ACTIVE')->where('created_at', '<', now())->exists()) {
            $this->info('No events to archive.');
            return;
        }

        DB::table('events')
            ->where('status', 'ACTIVE')
            ->where('start_date', '<', now())
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '<', now());
            })
            ->update(['status' => 'ARCHIVED']);

        $this->info('Events have been archived.');
    }
}
