<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use function Laravel\Prompts\pause;


class About_UsTest extends DuskTestCase
{
    /** @test */

    public function testEdit_Board_member(): void
    {
        $this->browse(function (Browser $browser) {
        $boardMember = \App\Models\BoardMember::orderBy('created_at', 'desc')->firstOrFail();

        $browser->visit("/board-members/{$boardMember->id}/edit")
                ->type('name', 'Bijgewerkte Naam')
                ->type('role', 'Voorzitter')
                ->type('bio', 'Bijgewerkte bio voor het bestuurslid.')
                ->press('Opslaan')
                ->assertPathIs("/board-members/{$boardMember->id}/edit")
                ->assertSee('Bestuurslid succesvol bijgewerkt!');
        });
    }

    public function testEdit_previous_board(): void
    {
        $this->browse(function (Browser $browser) {
        $previousBoard = \App\Models\PreviousBoard::orderBy('created_at', 'desc')->firstOrFail();

        $fromDate = now()->subYears(2)->format('Y-m-d');
        $toDate = now()->subYear()->format('Y-m-d');

        $browser->visit("/previous-boards/{$previousBoard->id}/edit")
                ->assertSee('Vorig Bestuur Bewerken')
                ->script([
                    "document.getElementById('FromYear').value = '{$fromDate}';",
                    "document.getElementById('ToYear').value = '{$toDate}';",
                ]);

        $browser->type('members', 'Bijgewerkte ledenlijst voor vorig bestuur.')
                ->press('Opslaan')
                ->assertPathIs("/previous-boards/{$previousBoard->id}/edit")
                ->assertSee('Vorig bestuur succesvol bijgewerkt!');
        });
    }


}
