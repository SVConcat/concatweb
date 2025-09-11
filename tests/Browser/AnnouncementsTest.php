<?php

namespace Tests\Browser;

use App\Models\Announcement;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AnnouncementsTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_announcements_page_structure()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/announcements')
                ->waitUntil('document.readyState === "complete"')
                ->assertSeeIn('h1', 'Aankondigingen')
                ->assertSee('Er zijn momenteel geen zichtbare aankondigingen');
        });
    }

    public function test_visible_announcements_are_shown()
    {
        $announcement = Announcement::factory()->create([
            'titel' => 'UNIEKE_TEST_TITEL_' . time(),
            'isVisible' => true
        ]);

        $this->browse(function (Browser $browser) use ($announcement) {
            $browser->visit('/announcements')
                ->waitForText($announcement->titel, 20)
                ->assertSee($announcement->titel);
        });
    }

    public function test_date_time_grouping()
    {
        Announcement::factory()->create([
            'publicatiedatum' => now()->subHour(),
            'titel' => 'VANDAAG_TEST',
            'isVisible' => true
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/announcements')
                ->waitForText('VANDAAG_TEST', 20)
                ->assertSee('Vandaag');
        });
    }
}
