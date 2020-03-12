<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanBeRedirectedIfAccessToAuthenticatedRouteTest extends TestCase
{
    use RefreshDatabase;

    public function GuestCanBeRedirectedIfAccessToAuthenticatedRouteTest()
    {
        $response = $this->get('/api/user');
        $response->assertRedirect('login');
    }
}
