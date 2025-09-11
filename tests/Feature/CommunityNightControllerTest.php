<?php

namespace Tests\Feature;

use App\Models\CommunityNight;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommunityNightControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the community night detail page returns a 200 status code.
     */
    public function test_show_returns_successful_response(): void
    {
        $communityNight = CommunityNight::factory()->create();

        $response = $this->get(route('community-nights.show', $communityNight));

        $response->assertStatus(200);
    }

    /**
     * Test that the community night detail page uses the correct view.
     */
    public function test_show_uses_correct_view(): void
    {
        $communityNight = CommunityNight::factory()->create();

        $response = $this->get(route('community-nights.show', $communityNight));

        $response->assertViewIs('community-nights.detail'); // Add the actual view name
    }

    /**
     * Test that the community night detail page passes the correct data to the view.
     */
    public function test_show_passes_community_night_to_view(): void
    {
        $communityNight = CommunityNight::factory()->create();

        $response = $this->get(route('community-nights.show', $communityNight));

        $response->assertViewHas('communityNight', function ($viewCommunityNight) use ($communityNight) {
            return $viewCommunityNight->id === $communityNight->id;
        });
    }

    /**
     * Test that the community night detail page displays all community night details.
     */
    public function test_show_displays_community_night_details(): void
    {
        $communityNight = CommunityNight::factory()->create([
            'title' => 'Test Community Night',
            'description' => 'This is a test description.',
            'start_time' => '2023-10-15 18:00:00',
            'end_time' => '2023-10-15 20:00:00',
            'location' => 'Test Location',
        ]);

        $response = $this->get(route('community-nights.show', $communityNight));

        $response->assertSee($communityNight->title)
            ->assertSee($communityNight->date)
            ->assertSee($communityNight->start_time)
            ->assertSee($communityNight->end_time)
            ->assertSee($communityNight->location)
            ->assertSee($communityNight->formattedDescription);
    }

    /**
     * Test that the show method returns a 404 for a non-existent community night.
     */
    public function test_show_returns_404_for_nonexistent_community_night(): void
    {
        $response = $this->get(route('community-nights.show', 999)); // Assuming 999 doesn't exist

        $response->assertStatus(404);
    }
}
