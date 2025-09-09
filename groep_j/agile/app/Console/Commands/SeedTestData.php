<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:testdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed test data for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', ['--class' => 'Database\\Seeders\\TestDataSeeder']);
        $this->info('Test data seeded successfully!');
    }
}
