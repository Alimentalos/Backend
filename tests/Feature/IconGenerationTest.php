<?php

namespace Tests\Feature;

use Tests\TestCase;

class IconGenerationTest extends TestCase
{
    public function test_icon_generation()
    {
        $this->artisan('generate:icons')
            ->assertExitCode(0);
    }
}
