<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CalenderTest extends DuskTestCase
{
    public function testIndexUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('user.calender.index')
                ->assertSee('Evenement');
        });
    }
}
