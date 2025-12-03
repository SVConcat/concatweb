<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\EventsToevoegen;
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
            'betaal_link' => 'https://test-betaal-link.com'
        ]);

        // Controleer of het event in de database staat
        $this->assertDatabaseHas('events', [
            'titel' => 'Test Event'
        ]);

        // Controleer of de gebruiker wordt doorgestuurd naar de juiste pagina
        $response->assertRedirect('/events/index');
    }
       /** @test */
    public function het_toont_events_geordend_op_startdatum_oplopend()
    {
        // Maak voorbeeld events aan met verschillende datums
        $event1 = events::create([
            'titel' => 'Event 1',
            'datum' => '2025-03-07',
            'starttijd' => '12:00',
            'eindtijd' => '14:00',
            'beschrijving' => 'Beschrijving van Event 1',
            'locatie' => 'Test Locatie',
            'aantal_beschikbare_plekken' => 50,
            'betaal_link' => 'https://event1.com',
            'afbeelding' => 'event1.jpg'
        ]);

        $event2 = events::create([
            'titel' => 'Event 2',
            'datum' => '2025-03-07',
            'starttijd' => '12:00',
            'eindtijd' => '14:00',
            'beschrijving' => 'Beschrijving van Event 2',
            'locatie' => 'Test Locatie',
            'aantal_beschikbare_plekken' => 50,
            'betaal_link' => 'https://event2.com',
            'afbeelding' => 'event2.jpg'
        ]);

        $event3 = events::create([
            'titel' => 'Event 3',
            'datum' => '2025-03-09',
            'starttijd' => '12:00',
            'eindtijd' => '14:00',
            'beschrijving' => 'Beschrijving van Event 3',
            'locatie' => 'Test Locatie',
            'aantal_beschikbare_plekken' => 50,
            'betaal_link' => 'https://event3.com',
            'afbeelding' => 'event3.jpg'
        ]);

        // Haal de pagina op met oplopende volgorde
        $response = $this->get('/events/index?sort=asc');

        // Controleer of de events in oplopende volgorde van datum worden weergegeven
        $response->assertStatus(200);
        $response->assertSeeInOrder([$event1->titel, $event2->titel, $event3->titel]);
    }
}

