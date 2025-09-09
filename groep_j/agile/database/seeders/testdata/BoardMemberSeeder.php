<?php

namespace Database\Seeders\testdata;

use App\Models\BoardMember;
use Illuminate\Database\Seeder;

class BoardMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BoardMember::factory(5)->create();
    }
}
