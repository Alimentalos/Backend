<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanGetNotFoundTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanGetNotFound()
    {
        $response = $this->get('/about/fakeUrl');
        $response->assertNotFound();
    }
}
