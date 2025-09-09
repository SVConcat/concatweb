<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(0, 100),
            'capacity' => $this->faker->numberBetween(0, 100),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'banner' => null,
            'payment_link' => $this->faker->url(),
            'category' => $this->faker->randomElement(['EVENT', 'DRINKS', 'COMMUNITY']),
            'gallery' => null,
            'status' => $this->faker->randomElement(['ACTIVE', 'ARCHIVED']),
            'is_open' => $this->faker->boolean(),
            'end_date' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            'location' => $this->faker->address(),
        ];
    }
}
