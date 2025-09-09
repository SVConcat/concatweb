<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EventsCrudTest extends DuskTestCase
{
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
            ->visitRoute('admin.events.index')
                ->assertSee('Event');
        });
    }

    public function testCreateEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visitRoute('admin.event.create');
            $browser->typeSlowly('title', 'test')
                ->type('description', 'test')
                ->select('category', 'DRINKS')
                ->type('price', '10')
                ->type('capacity', '10')
                ->type('payment_link', 'test')
                ->type('start_date', '2025-03-22T14:30');
            $browser->script([
                'document.getElementById("submitButton").scrollIntoView()',
                'document.getElementById("submitButton").click()'
            ]);
            $browser->loginAs(User::find(1))
                ->waitForLocation(route('admin.events.index'))
                ->assertSee('Event');
        });
    }

    public function testShowEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visitRoute('admin.event.show', 1)
                ->assertSee('Event');
        });
    }

    public function testUpdateEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visitRoute('admin.event.show', 1)
                ->type('title', 'test2')
                ->type('description', 'test2')
                ->type('start_date', '2026-03-22T14:30')
                ->select('category', 'EVENTS')
                ->type('price', '20')
                ->type('capacity', '20');
                $browser->script([
                    'document.getElementById("submitButton").scrollIntoView()',
                    'document.getElementById("submitButton").click()'
                ]);
                $browser->waitForLocation(route('admin.events.index'))
                ->assertSee('test');
        });
    }

    public function testDeleteEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visitRoute('admin.event.show', 1)
                ->script([
                    'document.getElementById("openModalDeleteButton").scrollIntoView()'
                ]);
                $browser->press('Evenement verwijderen')
                    ->waitForText('Weet je zeker dat je deze wilt verwijderen?')
                    ->press('Doorgaan')
                ->waitForLocation(route('admin.events.index'))
                ->assertDontSee('test2');
        });
    }
}
