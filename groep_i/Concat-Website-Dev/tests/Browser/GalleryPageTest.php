<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Gallery;

class GalleryPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function createAdminUser()
    {
        return User::factory()->create([
            'email' => 'admin@outlook.nl',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }

    protected function createPhoto()
    {
        return Gallery::factory()->create([
            'title' => 'Testfoto',
            'type' => 'blokborrel',
            'date' => now(),
            'src' => '/storage/gallery/test.jpg',
        ]);
    }

    /** @test */
    public function guest_can_view_gallery_but_not_see_add_photo_button()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/gallery')
                ->assertSee('Galerij')
                ->assertMissing('a[aria-label="Nieuwe foto toevoegen"]');
        });
    }

    /** @test */
    public function admin_can_see_add_photo_button_on_gallery_page()
    {
        $admin = $this->createAdminUser();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                ->type('email', $admin->email)
                ->type('password', 'admin123')
                ->press('Login')
                ->visit('/gallery')
                ->waitForText('Foto toevoegen')
                ->assertSee('Foto toevoegen')
                ->assertPresent('a[aria-label="Nieuwe foto toevoegen"]');
        });
    }

    /** @test */
    public function user_can_filter_gallery_by_type()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/gallery')
                ->assertPresent('select#type')
                ->select('type', 'blokborrel')
                ->pause(500)
                ->assertSelected('type', 'blokborrel');
        });
    }

     /** @test */
    public function admin_can_add_photo_via_create_page()
    {
        $admin = $this->createAdminUser();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                ->type('email', $admin->email)
                ->type('password', 'admin123')
                ->press('Login')
                ->visit('/gallery/create')
                ->type('title', 'Testfoto via Dusk')
                ->select('type', 'blokborrel')
                ->type('date', now()->format('Y-m-d'))
                ->press('Opslaan');
        });
    }

    /** @test */
    public function admin_can_edit_photo()
    {
        $admin = $this->createAdminUser();
        $photo = $this->createPhoto();

        $this->browse(function (Browser $browser) use ($admin, $photo) {
            $browser->visit('/login')
                ->type('email', $admin->email)
                ->type('password', 'admin123')
                ->press('Login')
                ->visit('/gallery')
                ->click('a[aria-label="Bewerk foto ' . $photo->title . '"]')
                ->waitForLocation("/gallery/{$photo->id}/edit")
                ->assertInputValue('title', $photo->title)
                ->type('title', 'Aangepaste titel')
                ->press('Opslaan');
        });
    }
}
