<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition()
    {
        return [
            'titel' => $this->faker->sentence,
            'inhoud' => $this->faker->paragraph,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'isVisible' => $this->faker->boolean(70), // 70% chance of being visible
        ];
    }
}
