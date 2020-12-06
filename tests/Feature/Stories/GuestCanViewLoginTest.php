<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanViewLoginTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanViewLogin()
    {
        $response = $this->get('/login');
        $response->assertOk();
    }
}
