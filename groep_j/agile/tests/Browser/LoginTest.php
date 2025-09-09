<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Set up database migrations before running tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    /**
     * Test login functionality.
     */
    public function test_login(): void
    {
        $user = User::factory()->create([
            'email' => 'taylor@laravel.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->assertSee('Inloggen')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('#login-btn')
                ->pause(500)
                ->assertPathIs('/');
            $browser->screenshot('login-test');
        });
    }
}
