<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class RegisterTest extends DuskTestCase
{
    public function test_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'Test Gebruiker')
                ->select('major', 'SO')
                ->type('email', 'test@example.com')
                ->type('phone', '0612345678')
                ->type('password', 'password123')
                ->type('password_confirmation', 'password123')
                ->screenshot('register')
                ->press('register')
                ->pause(500)
                ->assertPathIs('/');

        });
    }
}
