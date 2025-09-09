<?php

namespace Database\Seeders;

use App\Models\CommunityNight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunityNightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CommunityNight::create([
            'title' => 'Community Avond 1',
            'image' => 'community-nights/6815821700_8224103d9e.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-10-15 18:00:00',
            'end_time' => '2023-10-15 22:00:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 100,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 2',
            'image' => 'community-nights/6970631088_f8a396cc6a.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. , and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-10-22 18:30:00',
            'end_time' => '2023-10-22 21:30:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 90,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 3',
            'image' => null,
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-11-01 17:00:00',
            'end_time' => '2023-11-01 21:00:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 120,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 4',
            'image' => 'community-nights/8245735846_7edf33b44f.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',

            'start_time' => '2023-11-08 18:15:00',
            'end_time' => '2023-11-08 22:00:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 95,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 5',
            'image' => 'community-nights/8477361580_6e1f3fd6ce.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-11-15 19:00:00',
            'end_time' => '2023-11-15 22:30:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 110,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 6',
            'image' => 'community-nights/28091025389_41df4f7c99.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-11-22 17:30:00',
            'end_time' => '2023-11-22 20:30:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 85,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 7',
            'image' => 'community-nights/30193245810_7b7ff74cd5.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-11-29 18:00:00',
            'end_time' => '2023-11-29 22:00:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 100,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 8',
            'image' => 'community-nights/30212993894_85351f21ba.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-12-06 18:00:00',
            'end_time' => '2023-12-06 21:00:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 105,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 9',
            'image' => 'community-nights/36289482971_a3a77b523c.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-12-13 17:45:00',
            'end_time' => '2023-12-13 21:45:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 95,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 10',
            'image' => 'community-nights/36906009863_625ce02e9f.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-12-20 18:00:00',
            'end_time' => '2023-12-20 22:00:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 100,
        ]);

        CommunityNight::create([
            'title' => 'Community Avond 11',
            'image' => 'community-nights/8054431317_b18f235087.jpg',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'start_time' => '2023-12-27 18:00:00',
            'end_time' => '2023-12-27 22:00:00',
            'location' => 'Avans, s-Hertogenbosch',
            'link' => 'https://www.avans.nl/',
            'capacity' => 100,
        ]);
    }
}
