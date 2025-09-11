<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;

class AccountTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function createUser()
    {
        return User::factory()->create([
            'email' => 'client@outlook.nl',
            'password' => bcrypt('client123'),
            'role' => 'student',
        ]);
    }

    /** @test */
    public function user_can_view_their_account_information()
    {
        $user = $this->createUser();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', 'client@outlook.nl')
                ->type('password', 'client123')
                ->press('Login')
                ->visit('/account')
                ->assertSee($user->email)
                ->assertSee('Bewerk gegevens')
                ->assertSee('Wachtwoord')
                ->assertSee('••••••••');
        });
    }
}
