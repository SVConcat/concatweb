<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Newsletter;
class NewsLetterTest extends DuskTestCase
{
        use DatabaseMigrations;
    /**
     * A Dusk test example.
     */
  public function test_newsletter_index_page_loads_and_displays_elements()
    {
        // Create a test admin user
        $admin = User::factory()->create([
            'role' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/news')
                ->assertSee('Nieuwsbrieven')  // Ensure the page title is visible
                ->assertSee('Nieuwsbrief toevoegen') // Check if the 'Add Newsletter' button is present
                ->assertPresent('@nieuwsbrief-toevoegen'); // Ensure the button exists and is interactable
        });
    }


  public function test_newsletter_create_and_upload_functionality()
    {
        // Create a test admin user
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
                    // Create a temporary PDF file for testing
        $pdfPath = storage_path('app/public/test_newsletter.pdf');
        file_put_contents($pdfPath, '%PDF-1.4...');
            $browser->loginAs($admin)
                ->visit('/news')
                ->click('@nieuwsbrief-toevoegen')  // Click to go to the create newsletter page
                ->assertPathIs('/news/create')  // Ensure we're on the create page
                ->assertSee('Nieuwsbrief Uploaden')  // Check that the upload page has loaded
                ->type('titel', 'Test Nieuwsbrief')  // Fill out the title
                ->type('publicatiedatum', '2025-05-12')  // Fill out the publication date
                ->attach('pdf', $pdfPath)  // Attach the generated PDF file
                ->press('Uploaden')  // Submit the form
                ->assertPathIs('/newsletters')  // Check if we're redirected back to the newsletters list
                ->assertSee('Test Nieuwsbrief')  // Check that the new newsletter appears in the list
                ->assertSee('2025-05-12');  // Ensure the publication date is displayed
                
            unlink($pdfPath);

        });
    }

    
}
