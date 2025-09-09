<?php

namespace Tests\Browser;

use App\Models\Events;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EventRegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function link_zet_in_agenda_is_aanwezig_en_werkt()
    {
        $evenement = Events::factory()->create([
            'titel' => 'Test Evenement Dusk',
            'datum' => '2025-03-07',
            'starttijd' => '18:00',
            'eindtijd' => '22:00',
            'beschrijving' => 'Test beschrijving',
            'locatie' => 'Test Locatie',
            'aantal_beschikbare_plekken' => 50,
            'betaal_link' => 'https://test-betaal-link.com',
        ]);

        $this->browse(function (Browser $browser) use ($evenement) {
            $href = route('events.ics', $evenement->id);

            $browser->visit("/events/{$evenement->id}")
                ->assertSeeLink('Zet in agenda')
                ->assertAttribute("a[href='{$href}']", 'href', $href)
                ->clickLink('Zet in agenda');
        });
    }
    /** @test */
    public function admin_can_update_an_event()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $event = Events::factory()->create([
            'titel' => 'Originele Titel',
            'categorie' => 'blokborrel',
            'datum' => '2025-07-20',
            'einddatum' => '2025-07-21',
            'starttijd' => '18:00',
            'eindtijd' => '22:00',
            'beschrijving' => 'Oude beschrijving',
            'locatie' => 'Oude Locatie',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $event) {
            $browser->loginAs($admin)
                ->visit(route('events.edit', $event->id))
                ->assertInputValue('titel', 'Originele Titel')

                ->within('form', function ($form) {
                    $form->type('titel', 'Nieuwe Titel')
                        ->type('datum', '2025-07-22')
                        ->type('einddatum', '2025-07-23')
                        ->type('starttijd', '17:00')
                        ->type('eindtijd', '21:00')
                        ->type('beschrijving', 'Nieuwe beschrijving')
                        ->type('locatie', 'Nieuwe Locatie')
                        ->press('Evenement opslaan');
                });
        });
    }


    public function test_event_page_loads_and_registers()
    {
        $event = Events::factory()->create([
            'titel' => 'Test Event',
            'datum' => '2025-04-15',
            'starttijd' => '18:00',
            'einddatum' => '2025-04-15',
            'eindtijd' => '20:00',
            'locatie' => 'Testlocatie',
            'beschrijving' => 'Test beschrijving',
        ]);
    }

    public function test_event_page_loads_and_displays_elements()
    {
        $events = Events::factory()->count(5)->create();

        $this->browse(function (Browser $browser) use ($events) {
            $browser->visit('/events/index')
                ->waitForText('Filter op categorie:', 3)
                ->assertSee('Filter op categorie:')
                ->assertPresent('select#categorie')
                ->assertSee($events[0]->titel)
                ->assertSee($events[1]->titel)
                ->assertSee($events[2]->titel);
        });
    }

    public function test_event_detail_page_loads_and_registration_modal_functionality()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $event = Events::factory()->create([
            'titel' => 'Test Event',
            'categorie' => 'Test Category',
            'datum' => '2025-05-01',
            'starttijd' => '18:00',
            'einddatum' => '2025-05-01',
            'eindtijd' => '22:00',
            'locatie' => 'Test Location',
            'beschrijving' => 'This is a test description for the event.',
        ]);

        $this->browse(function (Browser $browser) use ($user, $event) {
            $browser->visit(route('events.show', $event->id))
                ->waitForText($event->titel, 3)
                ->assertSee($event->titel)
                ->assertSee($event->categorie)
                ->assertSee($event->locatie)
                ->assertSee($event->beschrijving)
                ->click('#openFormButton')
                ->pause(500)
                ->assertVisible('#popupModal')
                ->assertSee('Inschrijven')
                ->assertSee('Naam:')
                ->assertSee('E-mail:')
                ->click('#closePopup')
                ->pause(500);
        });
    }

    public function test_event_filter_dropdown_options()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $event = Events::factory()->create([
            'titel' => 'Test Event',
            'datum' => '2025-04-15',
            'starttijd' => '18:00',
            'einddatum' => '2025-04-15',
            'eindtijd' => '20:00',
            'locatie' => 'Testlocatie',
            'beschrijving' => 'Test beschrijving',
        ]);

        $this->browse(function (Browser $browser) use ($user, $event) {
            $browser->loginAs($user)
                ->visit('/events/index')
                ->assertSelected('select#categorie', 'all')
                ->assertPresent('select#myevents')
                ->assertSelected('select#myevents', '0')
                ->select('select#myevents', '1')
                ->pause(500)
                ->assertSelected('select#myevents', '1')
                ->assertSee('Ingeschreven')
                ->select('select#myevents', '0')
                ->pause(500)
                ->assertSelected('select#myevents', '0')
                ->assertSee('Alles');
        });
    }


}
