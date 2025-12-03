<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AboutPageTest extends DuskTestCase
{
    /**
     * Test de Over Concat pagina.
     */
    public function testAboutConcatPageDisplaysCorrectly()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/about-us')
                ->assertSee('Over Concat')
                ->assertSee('Huidig Bestuur')
                ->assertSee('Vorige Besturen')
                ->assertSee('Bestuurslid worden?');

        // Minimaal één bestuurslidkaart zichtbaar
        $browser->assertPresent('.grid > div');

        // Tijdlijncontainer aanwezig
        $browser->assertPresent('#timeline');

        // Lees meer knop werkt
        $browser->click('.bio-container button')
                ->assertSee('Lees minder');

        // Scrollknoppen tijdlijn testen
        $browser->assertPresent('button[aria-label="Scroll naar rechts op de tijdlijn"]')
                ->click('button[aria-label="Scroll naar rechts op de tijdlijn"]')
                ->pause(500); // Wacht op scroll-animatie

        // Test of het scrollen effect heeft (visueel moeilijk vast te stellen zonder scrollpositie)
        // Dus je test bijv. of een van de laatste jaren zichtbaar is
        $browser->assertSeeIn('#timeline', date('Y') - 1); // Of andere specifieke jaartal
    });
}
}
