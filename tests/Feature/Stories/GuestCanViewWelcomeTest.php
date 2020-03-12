<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanViewWelcomeTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanViewWelcome()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
