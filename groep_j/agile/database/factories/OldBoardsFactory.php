<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OldBoardsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'names' => $this->faker->sentence(),
            'term' => $this->faker->numberBetween(2023, 2030) . '/' . ($this->faker->numberBetween(2023, 2030) + 1),
            'image' => null,
        ];
    }
}
