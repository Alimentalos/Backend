<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IconGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_icon_generation()
    {
        $this->artisan('generate:icons')
            ->assertExitCode(0);
    }
}
