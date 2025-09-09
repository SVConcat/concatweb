<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use function Laravel\Prompts\pause;


class CommunityNightTest extends DuskTestCase
{
    /** @test */

    public function create_communityNight(): void
    {

        $this->browse(function (Browser $browser) {
            $startTime = \Carbon\Carbon::now()->addDay()->setTime(19, 30)->format("Y-m-d\TH:i");
            $endTime = \Carbon\Carbon::now()->addDay()->setTime(21, 30)->format("Y-m-d\TH:i");
        
            $browser->visit('/community-nights/create')
                    ->type('title', 'Community Avond Test')
                    ->type('description', 'Een gezellige avond voor Laravel ontwikkelaars.')
                    ->script([
                        "document.getElementById('start_time').value = '{$startTime}';",
                        "document.getElementById('end_time').value = '{$endTime}';",
                    ]);
        
            $browser->type('location', 'Amsterdam, NL')
                    ->type('capacity', '50')
                    ->press('Toevoegen')
                    ->assertPathIs('/community-nights')
                    ->assertSee('Community Avond Test');
        });
        
    }

    public function testEdit_communityNight(): void
    {
        $this->browse(function (Browser $browser) { 

        $communityNight = \App\Models\CommunityNight::orderBy('created_at', 'desc')->firstOrFail();

            $browser->visit("/community-nights/{$communityNight->id}/edit")
                    ->assertSee('Community avond bewerken')
                    ->type('title', 'Community Avond Gewijzigd')
                    ->type('description', 'Bijgewerkte beschrijving voor de Laravel community avond.')
                    ->script([
                    "document.getElementById('start_time').value = '" . now()->addDays(2)->setTime(18, 0)->format('Y-m-d\TH:i') . "';",
                    "document.getElementById('end_time').value = '" . now()->addDays(2)->setTime(20, 30)->format('Y-m-d\TH:i') . "';",
                    ]);

            $browser->type('location', 'Rotterdam, NL')
                    ->type('capacity', '75')
                    ->press('Opslaan')
                    ->assertPathIs("/community-nights/{$communityNight->id}/edit")
                    ->assertSee('Community avond succesvol bijgewerkt!');
         });
    }

    public function testDelete_communityNight():void{

        $this->browse(function (Browser $browser) {

            $browser->visit('/login')
                    ->type('email','admin@outlook.nl')
                    ->type('password','admin123')
                    ->press('Login');
    
            $browser->visit('/community-nights');
                    

                    $communityNight = \App\Models\CommunityNight::factory()->create();
            
            $browser->visit('/community-nights')
                    ->waitFor('@delete-communityNight-' . $communityNight->id);

            $browser->click('@delete-communityNight-' . $communityNight->id)
                    ->waitForDialog(5)
                    ->acceptDialog()
                    ->pause(1000);

            $browser->assertDontSee($communityNight->title)
                    ->assertSee('Community Night succesvol verwijderd');
                });     

    }



}
