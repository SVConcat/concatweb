<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryFactory extends Factory
{
    protected $model = \App\Models\Gallery::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'type' => $this->faker->randomElement(['blokborrel', 'education']),
            'date' => $this->faker->date(),
            'src' => 'https://picsum.photos/seed/' . Str::random(8) . '/400/300', // random image
        ];
    }
}
