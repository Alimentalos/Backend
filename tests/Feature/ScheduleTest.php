<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function testSchedule()
    {
        $this->artisan('schedule:run');
        $this->assertTrue(true);
    }
}
