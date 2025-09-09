<?php

namespace Database\Seeders\testdata;

use App\Models\OldBoards;
use Illuminate\Database\Seeder;

class OldBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OldBoards::factory(5)->create();
    }
}
