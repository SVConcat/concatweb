<?php

namespace Tests\Browser;

use Laravel\Dusk\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class DuskTestCase extends BaseTestCase
{
    use DatabaseMigrations;

    /**
     * Prepare for Dusk test execution.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }
}
