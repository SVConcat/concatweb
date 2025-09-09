<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
{

    public function test_update_profile_information(){

        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->type('name', 'Nieuwe Naam')
                ->type('email', 'nieuwe@email.com')
                ->type('phone', '0612345678')
                ->press('Update gegevens')
                ->pause(500)
                ->assertPathIs('/profile')
                ->assertInputValue('name', 'Nieuwe Naam');
        });
    }

    public function test_update_password(){
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->type('current_password', 'test1234')
                ->type('password', 'newpassword')
                ->type('password_confirmation', 'newpassword')
                ->press('Update wachtwoord')
                ->pause(500)
                ->assertPathIs('/profile');
        });
    }
}
