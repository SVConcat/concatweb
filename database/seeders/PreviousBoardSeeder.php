<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreviousBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('previous_boards')->insert([
            [
                'FromYear' => '2024-09-01',
                'ToYear' => '2025-07-01',
                'members' => 'Jules Verbruggen, Sven Lempers, Kim Nijsten, Bas Brekelmans, Josha van Engelen',
                'photo' => 'about-us/personal/board/bestuur_2024_2025_concat.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'FromYear' => '2023-09-01',
                'ToYear' => '2024-07-01',
                'members' => 'Josha van Engelen, Kevin Bouwmeester, Emily Braun',
                'photo' => 'about-us/personal/board/bestuur_2023_2024_concat.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'FromYear' => '2022-09-01',
                'ToYear' => '2023-07-01',
                'members' => 'Jesse van den Ende, Carli van Zandvoort, Noor Houben, Stijn Lingmont',
                'photo' => 'about-us/personal/board/bestuur_2022_2023_concat.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'FromYear' => '2021-09-01',
                'ToYear' => '2022-07-01',
                'members' => 'Tessa Hoeben, Linn Smetsers, Niels Verheggen, Ruben Dommerholt',
                'photo' => 'about-us/personal/board/bestuur_2021_2022_concat.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
//            [
//                'FromYear' => '2020-09-01',
//                'ToYear' => '2021-07-01',
//                'members' => 'Emma, Lars, Sophie, Noah',
//                'photo' => 'about-us/personal/board/testfoto.png',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
        ]);
    }
}
