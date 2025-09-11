<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Events;

class EventsTest extends TestCase
{
    use RefreshDatabase; // Zorgt ervoor dat de database wordt geleegd na elke test

    /** @test */
    public function een_event_kan_worden_aangemaakt()
    {
        // Simuleer een POST request met testdata
        $response = $this->post('/events/create', [
            'titel' => 'Test Event',
            'datum' => '2025-03-07',
            'starttijd' => '18:00',
            'eindtijd' => '22:00',
            'beschrijving' => 'Dit is een testbeschrijving.',
            'locatie' => 'Test Locatie',
            'aantal_beschikbare_plekken' => 50,
            'betaal_link' => 'https://test-betaal-link.com',
            'categorie' => 'Event'
        ]);

        // Controleer of het event in de database staat
        $this->assertDatabaseHas('events_toevoegen', [
            'titel' => 'Test Event'
        ]);

        // Controleer of de gebruiker wordt doorgestuurd naar de juiste pagina
        $response->assertRedirect('/events/index');
    }
}
