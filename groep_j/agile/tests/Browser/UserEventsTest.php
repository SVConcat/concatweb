<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserEventsTest extends DuskTestCase
{
    public function testIndexEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('user.events.index')
                ->assertSee('Lees verder');
        });
    }

    public function testShowEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('user.event.show', 1)
                ->assertSee('Event');
        });
    }

    public function testRegisterEventWithoutLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('user.event.show', 1)
                ->assertSee('Inloggen');
        });
    }

    public function testRegisterEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visitRoute('user.event.show', 1)
                ->press('Inschrijven')
                ->assertSee('Afmelden');
        });
    }

    public function testUnregisterEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visitRoute('user.event.show', 1)
                ->press('Afmelden')
                ->assertSee('Inschrijven');
        });
    }
}
