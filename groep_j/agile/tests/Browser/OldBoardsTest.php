<?php

namespace Tests\Browser;


use App\Models\OldBoards;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\BoardMember;

class OldBoardsTest extends DuskTestCase
{
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/old_boards')
                ->assertPathIs('/admin/old_boards')
                ->assertSee('Voeg oud bestuur toe');
        });
    }

    public function testCreateOldBoard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/old_boards/create')
                ->assertSee('Voeg oud bestuur toe')
                ->typeSlowly('names', 'John Doe,jan piet')
                ->typeSlowly('term', '2024/2025')
//                ->attach('image', storage_path('app/public/images/test-image.jpg'))
                ->press('Voeg oud bestuur toe');


            $browser->waitForLocation('/admin/old_boards')
                ->assertSee('John Doe,jan piet');
        });
    }

    public function testShowOldBoard()
    {
        $oldBoards = OldBoards::first(); // Ensure there's a board member

        $this->browse(function (Browser $browser) use ($oldBoards) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/old_boards/')
                ->pause(2000)
                ->assertSee($oldBoards->names);
        });
    }

    public function testUpdateOldBoard()
    {
        $oldBoards = OldBoards::first();

        $this->browse(function (Browser $browser) use ($oldBoards) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/old_boards/' . $oldBoards->id)
                ->typeSlowly('names', 'jane Doe,peter')
                ->typeSlowly('term', '2025/2026')
//                ->attach('image', storage_path('app/public/images/new-image.jpg'))
                ->press('Bewerk oud bestuur');

            $browser->waitForLocation('/admin/old_boards')
                ->assertSee('jane Doe,peter');
        });
    }

    public function testDeleteOldBoard()
    {
        $boardMember = OldBoards::first();

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/old_boards/' . $boardMember->id)
                ->pause(2000)
                ->press('Oud bestuur verwijderen')
                ->press('Doorgaan')
                ->waitForLocation('/admin/old_boards')
                ->assertDontSee('jane Doe,peter');
        });
    }
}
