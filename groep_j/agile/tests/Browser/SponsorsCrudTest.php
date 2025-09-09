<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SponsorsCrudTest extends DuskTestCase
{
    public function testIndexAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.sponsors.index')
                ->assertSee('sponsors');
        });
    }

    public function testIndexUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('user.sponsors.index')
                ->assertSee('sponsors');
        });
    }

    public function testCreateSponsor() {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.sponsor.create')
                ->type('name', 'test sponsor')
                ->type('description', 'test sponsor description')
                ->attach('image', storage_path('app/public/images/banner-2.jpg')) // change image to your own
                ->select('active', 'active')
                ->press('Add sponsor')
                ->waitForLocation(route('admin.sponsors.index'))
                ->assertSee('test');
        });
    }
    public function testShowSponsorAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.sponsor.show', 1)
                ->assertSee('Sponsor');
        });
    }

    public function testUpdateSponsor(){
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.sponsor.show', 16)
                ->type('name', 'test sponsor updated')
                ->type('description', 'test sponsor description updated')
                ->select('active', 'inactive')
                ->press('Update sponsor')
                ->waitForLocation(route('admin.sponsors.index'))
                ->assertSee('test');
        });
    }

    public function testCreateSponsorWithEvents() {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.sponsor.create')
                ->type('name', 'test sponsor with events')
                ->type('description', 'test sponsor description with events')
                ->attach('image', storage_path('app/public/images/banner-2.jpg')) // change image to your own
                ->select('active', 'active')
                ->check('events[]', 1)
                ->check('events[]', 2)
                ->press('Add sponsor')
                ->waitForLocation(route('admin.sponsors.index'))
                ->assertSee('test');
        });
    }

    public function testUpdateSponsorWithEvents() {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.sponsor.show', 16)
                ->type('name', 'test sponsor with events updated')
                ->type('description', 'test sponsor description with events updated')
                ->select('active', 'inactive')
                ->check('events[]', 1)
                ->press('Update sponsor')
                ->waitForLocation(route('admin.sponsors.index'))
                ->assertSee('test');
        });
    }

    public function testDeleteSponsor()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.sponsor.show', 18)
                ->press('Sponsor verwijderen')
                ->waitForLocation(route('admin.sponsors.index'))
                ->assertDontSee('test sponsor with events');
        });
    }
}
