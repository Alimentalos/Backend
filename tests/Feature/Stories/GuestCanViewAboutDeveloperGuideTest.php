<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanViewAboutDeveloperGuideTest extends TestCase
{
    use RefreshDatabase;

    public function GuestCanViewAboutDeveloperGuideTest()
    {
        $response = $this->get('/about/developer-guide');
        $response->assertOk();
    }
}
