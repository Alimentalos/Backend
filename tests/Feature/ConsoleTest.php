<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_schedule_run()
    {
        $this->artisan('schedule:run');
        $this->assertTrue(true);
    }
}
