<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Rooster;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RoosterCalendarTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testRoosterCalendarPageIsAccessible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/rooster')
                    ->assertPathIs('/rooster');
        });
    }
    /** @test */
    public function user_can_add_and_interact_with_rooster()
{
    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => bcrypt('password123'),
        'role' => 'admin',
    ]);

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/roosters')

                // Basiscomponenten aanwezig
                ->assertPresent('[data-dusk="rooster-page"]')
                ->assertPresent('[data-dusk="calendar"]')
                ->assertPresent('[data-dusk="rooster-form"]')

                // Rooster toevoegen
                ->type('[data-dusk="input-ical-url"]', 'https://rooster.avans.nl/gcal/test-ical-url')
                ->select('[data-dusk="select-klas"]', '1')
                ->press('[data-dusk="btn-add-rooster"]')
                ->waitFor('[data-dusk="form-success"]', 5)
                ->assertSee('Roosterlink opgeslagen!');

        // Check of toegevoegde rooster zichtbaar is
        $shortName = substr('https://rooster.avans.nl/gcal/test-ical-url', -10);

        $browser->assertPresent("[data-dusk='calendar-item-{$shortName}']")
                ->assertPresent("[data-dusk='checkbox-{$shortName}']")
                ->assertPresent("[data-dusk='delete-form-{$shortName}']")
                ->assertPresent("[data-dusk='btn-delete-{$shortName}']");

        //  Grafiek aanwezig
        if ($browser->element('[data-dusk="hourly-chart"]')) {
            $browser->assertPresent('[data-dusk="chart-legend"]');
        } else {
            $browser->assertPresent('[data-dusk="no-data-message"]');
        }

        // Verborgen lessenlijst controleren 
        $lessonItems = $browser->elements('[data-dusk^="lesson-"]');
        if (count($lessonItems) > 0) {
            $browser->assertVisible('[data-dusk^="lesson-0"]');
        }

        //  checkbox toggelen
        $browser->check("[data-dusk='checkbox-{$shortName}']")
                ->uncheck("[data-dusk='checkbox-{$shortName}']");

        // Verwijderen van rooster
        $browser->script("confirm = function() { return true; }"); // om bevestiging te automatiseren
        $browser->press("[data-dusk='btn-delete-{$shortName}']")
                ->pause(1000)
                ->assertMissing("[data-dusk='calendar-item-{$shortName}']");
    });
}

     public function user_can_create_a_rooster()
    {
    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => bcrypt('password123'), // Ensure password is set
        'role' => 'admin', // Add the role field here
    ]);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/roosters') // Zorg dat dit de juiste URL is
                    ->assertPresent('@rooster-form')
                    ->type('@input-ical-url', 'https://rooster.avans.nl/gcal/test123')
                    ->select('@select-klas', '2')
                    ->press('@btn-add-rooster')
                    ->waitFor('@form-success')
                    ->assertSeeIn('@form-success', 'success'); // Pas dit aan als jouw session message anders is
        });
    }
}
