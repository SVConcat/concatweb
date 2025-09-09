<?php

namespace Tests\Browser;


use App\Models\Commission;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\BoardMember;

class CommissionTest extends DuskTestCase
{
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/commissions')
                ->assertPathIs('/admin/commissions')
                ->assertSee('Voeg commissie toe');
        });
    }

    public function testCreateCommission()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/commission/create')
                ->assertSee('Voeg commissie toe')
                ->typeSlowly('name', 'slagers commissie')
                ->typeSlowly('description', 'This is a test commission.')
                ->press('Voeg commissie toe');


            $browser->waitForLocation('/admin/commissions')
                ->assertSee('slagers commissie');
        });
    }

    public function testShowCommission()
    {
        $Commission = Commission::first(); // Ensure there's a board member

        $this->browse(function (Browser $browser) use ($Commission) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/commissions/')
                ->pause(2000)
                ->assertSee($Commission->name);
        });
    }

    public function testUpdateCommission()
    {
        $boardMember = Commission::first();

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/commission/' . $boardMember->id)
                ->typeSlowly('name', 'bakers commissie')
                ->typeSlowly('description', 'Updated description.')
                ->press('Bewerk commissie');

            $browser->waitForLocation('/admin/commissions')
                ->assertSee('bakers commissie');
        });
    }

    public function testDeleteCommission()
    {
        $boardMember = Commission::first();

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/commission/' . $boardMember->id)
                ->pause(2000)
                ->press('Commissie verwijderen')
                ->press('Doorgaan')
                ->waitForLocation('/admin/commissions')
                ->assertDontSee('bakers commissie');
        });
    }
}
