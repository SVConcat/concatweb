<?php

namespace Database\Seeders;

use Database\Seeders\testdata\AnnouncementSeeder;
use Database\Seeders\testdata\BoardMemberSeeder;
use Database\Seeders\testdata\CommissionSeeder;
use Database\Seeders\testdata\EventSeeder;
use Database\Seeders\testdata\OldBoardSeeder;
use Database\Seeders\testdata\SponsorSeeder;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AnnouncementSeeder::class,
            BoardMemberSeeder::class,
            CommissionSeeder::class,
            EventSeeder::class,
            OldBoardSeeder::class,
            SponsorSeeder::class,
        ]);
    }
}
