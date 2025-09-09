<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\BoardMember;
use App\Models\Commission;
use App\Models\OldBoards;
use function Laravel\Prompts\pause;


class AboutUsPageTest extends DuskTestCase
{
    use DatabaseMigrations;
    public function testAboutUsPageDisplaysContent()
    {
        // Create mock data
        $board = BoardMember::factory()->create([
            'name' => 'John Doe',
            'description' => 'Board description',
            'role' => 'member',
        ]);

        $commission = Commission::factory()->create([
            'name' => 'Tech Committee',
            'description' => 'Handles all tech stuff',
        ]);

        $oldBoard = OldBoards::factory()->create([
            'term' => '2022/2023',
        ]);

        $this->browse(function (Browser $browser) use ($board, $commission, $oldBoard) {
            $browser->visit('/about-us')
                ->assertSee('Over Ons')
                ->scrollIntoView("div.comiboards")
                ->assertSee($board->name)
                ->scrollIntoView("div.info")
                ->assertSee($commission->name)
                ->scrollIntoView("#gallerySwiper")
                ->assertSee($oldBoard->term);
        });
    }
}
