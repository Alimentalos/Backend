<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanViewAboutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testGuestCanViewAbout
     */
    public function testGuestCanViewAbout()
    {
        $response = $this->get('/about');
        $response->assertOk();
    }
}
