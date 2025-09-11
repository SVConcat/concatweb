<?php

namespace Database\Seeders;

use App\Models\CommunityNight;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EventsSeeder::class,
            UsersSeeder::class,
            AnnouncementSeeder::class,
            SponsorSeeder::class,
            CommunityNightsSeeder::class,
            AssignmentsSeeder::class,
            GallerySeeder::class,
            BoardMemberSeeder::class,
            PreviousBoardSeeder::class,
        ]);
    }
}
