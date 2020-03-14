<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanViewAboutDeveloperHandbookTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanViewAboutDeveloperHandbook()
    {
        $response = $this->get('/about/developer-handbook');
        $response->assertOk();
    }
}
