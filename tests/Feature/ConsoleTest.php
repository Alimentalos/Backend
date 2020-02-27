<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConsoleTest extends TestCase
{
    public function test_schedule_run()
    {
        $this->artisan('schedule:run');
        $this->assertTrue(true);
    }
}
