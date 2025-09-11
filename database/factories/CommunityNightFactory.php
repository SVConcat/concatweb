<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommunityNight>
 */
class CommunityNightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Community Avond: ' . fake()->word(),
            'description' => fake()->paragraph(20),
            'start_time' => fake()->dateTime(),
            'end_time' => fake()->dateTime(),
            'location' => fake()->address(),
            'link' => fake()->url(),
            'capacity' => fake()->numberBetween(10, 100)
        ];
    }
}
