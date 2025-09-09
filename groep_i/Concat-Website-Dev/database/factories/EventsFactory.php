<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Events;


class EventsFactory extends Factory
{
    protected $model = Events::class;

    public function definition(): array
    {
        return [
            'titel' => $this->faker->sentence,
            'categorie' => $this->faker->randomElement(['blokborrel', 'education']),
            'datum' => now()->toDateString(),
            'einddatum' => now()->toDateString(),
            'starttijd' => '18:00',
            'eindtijd' => '20:00',
            'beschrijving' => $this->faker->paragraph,
            'locatie' => $this->faker->city,
            'aantal_beschikbare_plekken' => $this->faker->numberBetween(10, 100),
            'betaal_link' => $this->faker->url,
            'afbeelding' => 'https://via.placeholder.com/600x400.png?text=Event',
        ];
    }
}
