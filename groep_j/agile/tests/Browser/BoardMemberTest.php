<?php

namespace Tests\Browser;


use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\BoardMember;

class BoardMemberTest extends DuskTestCase
{
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/boards')
                ->assertPathIs('/admin/boards')
                ->assertSee('Voeg bestuur lid toe');
        });
    }

    public function testCreateBoardMember()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/board/create')
                ->assertSee('Voeg bestuur lid toe')
                ->typeSlowly('name', 'John Doe')
                ->typeSlowly('role', 'Chairman')
                ->typeSlowly('description', 'This is a test board member.')
                ->press('Voeg bestuur lid toe');


            $browser->waitForLocation('/admin/boards')
                ->assertSee('John Doe');
        });
    }

    public function testShowBoardMember()
    {
        $boardMember = BoardMember::first();

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/boards/')
                ->pause(2000)
                ->assertSee($boardMember->name);
        });
    }

    public function testUpdateBoardMember()
    {
        $boardMember = BoardMember::first();

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/board/' . $boardMember->id)
                ->typeSlowly('name', 'Jane Doe')
                ->typeSlowly('role', 'Vice Chairman')
                ->typeSlowly('description', 'Updated description.')
                ->press('Bewerk bestuur lid');

            $browser->waitForLocation('/admin/boards')
                ->assertSee('Jane Doe');
        });
    }

    public function testDeleteBoardMember()
    {
        $boardMember = BoardMember::first();

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/board/' . $boardMember->id)
                ->pause(2000)
                ->press('Bestuurslid verwijderen')
                ->press('Doorgaan')
                ->waitForLocation('/admin/boards')
                ->assertDontSee('Jane Doe');
        });
    }
}
