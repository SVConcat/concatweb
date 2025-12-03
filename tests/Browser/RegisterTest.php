<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// TODO: Use database migrations to refresh database before each test run

class RegisterTest extends DuskTestCase
{
    /** @test */

    // public function a_user_can_register(): void
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/register')
    //                 //->assertSee('Registreren');
    //                 ->type('name','Mohamed')
    //                 ->type('email','test@outlook.nl')
    //                 ->type('password','test12345')
    //                 ->type('password_confirmation','test12345')
    //                 ->press('Register')
    //                 ->assertPathIs('/index_event')
    //                 ->assertSee('Events');
    //     });
    // }


         /** @test */

    public function a_user_can_LogIn_and_Logout(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    //->assertSee('Registreren');
                    ->type('email','client@outlook.nl')
                    ->type('password','client123')
                    ->press('Login')
                    ->assertPathIs('/events/index')
                    ->assertSee('Logout')
                    ->clickLink('Logout');
        });
    }


        /** @test */

    // public function a_user_can_login(): void
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/login')
    //                 //->assertSee('Registreren');
    //                 ->type('email','client@outlook.nl')
    //                 ->type('password','client123')
    //                 ->press('Login')
    //                 ->assertPathIs('/index_event')
    //                 ->assertSee('Events');
    //     });
    // }


}
