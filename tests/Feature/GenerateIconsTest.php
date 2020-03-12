<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateIconsTest extends TestCase
{
    use RefreshDatabase;

    public function testGenerateIcons()
    {
        $this->artisan('generate:icons')
            ->assertExitCode(0);
    }
}
