<?php

namespace Tests\Browser;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class FooterTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testFooterIsVisible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Privacyverklaring')
                ->assertSee('Instagram')
                ->assertSee('LinkedIn')
                ->assertSee('Discord');
        });
    }


    /**
     * Test of de social media links werken.
     */
    public function testSocialMediaLinks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertAttribute('a[aria-label="Instagram"]', 'href', 'https://www.instagram.com/svconcat')
                ->assertAttribute('a[aria-label="LinkedIn"]', 'href', 'https://www.linkedin.com/company/sv-concat')
                ->assertAttribute('a[aria-label="Discord"]', 'href', 'https://discord.gg/AMYt823VPJ');
        });
    }

    /**
     * Test of de privacyverklaring link correct werkt.
     */
    public function testPrivacyverklaringLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('a[href="/privacyverklaring"]')
                ->click('a[href="/privacyverklaring"]')
                ->assertPathIs('/privacyverklaring');
        });
    }

    /**
     * Test of de e-mail link correct werkt.
     */
    public function testEmailLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertAttribute('a[href="mailto:info@svconcat.nl"]', 'href', 'mailto:info@svconcat.nl');
        });
    }

    /**
     * Test of de footer correct is op mobiel en desktop.
     */
    public function testFooterResponsive()
    {
        $this->browse(function (Browser $browser) {
            // Mobiele weergave
            $browser->resize(375, 667) // iPhone SE formaat
            ->assertVisible('footer')
                ->assertMissing('span.hidden.md:inline'); // "|" separator moet verborgen zijn

            // Desktop weergave
            $browser->resize(1920, 1080)
                ->assertVisible('footer')
                ->assertVisible('span.hidden.md:inline'); // "|" separator moet zichtbaar zijn
        });
    }
}
