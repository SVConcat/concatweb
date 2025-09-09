<?php

namespace Tests\Browser;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AnnouncementTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_create_announcement()
    {
        $admin = User::where('email', 'admin@agile.nl')->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/announcements/create')
                ->waitFor('#title')
                ->type('#title', 'Nieuwe Aankondiging')
                ->type('#description', 'Dit is een testaankondiging.')
                ->press('Aanmaken')
                ->pause(1000)
                ->assertSee('Nieuwe Aankondiging');
        });
    }

    public function test_edit_announcement()
    {
        $admin = User::where('email', 'admin@agile.nl')->first();
        $announcement = Announcement::factory()->create([
            'title' => 'Oude Titel',
            'description' => 'Origineel',
        ]);

        $this->browse(function (Browser $browser) use ($announcement, $admin) {
            $browser->loginAs($admin)
                ->visit("/announcements/{$announcement->id}/edit")
                ->waitFor('#title')
                ->type('#title', 'Gewijzigde Titel')
                ->type('#description', 'Gewijzigde omschrijving')
                ->press('Bijwerken')
                ->pause(1000)
                ->assertSee('Gewijzigde Titel');
        });
    }

    public function test_delete_announcement()
    {
        $admin = User::where('email', 'admin@agile.nl')->first();
        $announcement = Announcement::factory()->create([
            'title' => 'Te Verwijderen Aankondiging',
        ]);

        $this->browse(function (Browser $browser) use ($announcement, $admin) {
            $browser->loginAs($admin)
                ->visit('/announcements')
                ->waitFor("@delete-announcement-{$announcement->id}")
                ->click("@delete-announcement-{$announcement->id}")
                ->pause(500)
                ->with('#deleteModal', function ($modal) {
                    $modal->press('Verwijderen');
                })
                ->pause(1000)
                ->assertDontSee('Te Verwijderen Aankondiging');
        });
    }
}
