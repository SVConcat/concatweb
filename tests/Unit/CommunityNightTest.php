<?php

namespace Tests\Unit;

use App\Models\CommunityNight;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CommunityNightTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_formats_start_time_correctly(): void
    {
        // Create a CommunityNight instance with a specific start_time
        $communityNight = CommunityNight::factory()->create([
            'start_time' => '2025-10-15 18:30:00',
        ]);

        // Assert that the start_time accessor formats the time correctly
        $this->assertEquals('18:30', $communityNight->start_time);
    }

    #[Test]
    public function it_formats_end_time_correctly(): void
    {
        // Create a CommunityNight instance with a specific end_time
        $communityNight = CommunityNight::factory()->create([
            'end_time' => '2025-10-15 22:00:00',
        ]);

        // Assert that the end_time accessor formats the time correctly
        $this->assertEquals('22:00', $communityNight->end_time);
    }

    #[Test]
    public function it_formats_date_correctly(): void
    {
        // Create a CommunityNight instance with a specific start_time
        $communityNight = CommunityNight::factory()->create([
            'start_time' => '2023-10-15 18:30:00',
        ]);

        // Assert that the date accessor formats the date correctly
        $this->assertEquals('15-10-2023', $communityNight->date);
    }

    #[Test]
    public function it_formats_description_correctly(): void
    {
        // Create a CommunityNight instance with a description containing a new line character
        $communityNight = CommunityNight::factory()->create([
            'description' => "Line 1\nLine 2",
        ]);

        // Assert that the formattedDescription accessor converts new line characters to <br />
        $this->assertEquals("Line 1<br />\nLine 2", $communityNight->formattedDescription);
    }

    #[Test]
    public function it_formats_updated_at_correctly(): void
    {
        // Create a CommunityNight instance with a specific updated_at timestamp
        $communityNight = CommunityNight::factory()->create([
            'updated_at' => '2023-10-15 12:00:00',
        ]);

        // Assert that the updated_at accessor formats the updated_at timestamp correctly
        $this->assertEquals('15-10-2023', $communityNight->updated_at);
    }
}
