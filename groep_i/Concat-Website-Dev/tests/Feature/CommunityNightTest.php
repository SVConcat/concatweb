<?php
 
 namespace Tests\Feature;
 
 use Illuminate\Foundation\Testing\RefreshDatabase;
 use Illuminate\Foundation\Testing\WithFaker;
 use Tests\TestCase;
 use App\Models\CommunityNight;
 use PHPUnit\Framework\Attributes\Test;
 use Illuminate\Support\Facades\Storage;
 use Illuminate\Http\UploadedFile;

 use Illuminate\Foundation\Testing\DatabaseTransactions;


 
 class CommunityNightTest extends TestCase
 {
 
    //  #[Test]
    //  public function it_creates_a_community_night_with_valid_data()
    //  {
    //      // Fake de opslag, zodat er geen echte bestanden worden opgeslagen
    //      Storage::fake('public');
 
    //      $file = UploadedFile::fake()->image('test.jpg');
 
    //      $response = $this->post('/ReadCommunityNight', [
    //          'title' => 'Community Event',
    //          'image' => $file,
    //          'description' => 'A fun event.',
    //          'start_time' => '2024-06-01 18:00:00',
    //          'end_time' => '2024-06-01 22:00:00',
    //          'location' => 'City Park',
    //          'link' => 'http://example.com',
    //          'capacity' => 100,
    //      ]);
 
    //      $response->assertRedirect('/ReadCommunityNight');
 
    //      // Controleer of de data correct in de database staat
    //      $this->assertDatabaseHas('community_nights', [
    //          'title' => 'Community Event',
    //          'description' => 'A fun event.',
    //          'location' => 'City Park',
    //      ]);
 
    //     $this->assertTrue(Storage::disk('public')->exists('community_images/' . $file->hashName()));

    //  }
     
 
    //  #[Test]
    // public function it_requires_a_title()
    // {
    //     $response = $this->post('/ReadCommunityNight', [
    //         'title' => '',
    //     ]);

    //     $response->assertSessionHasErrors('title');
    // }
 }