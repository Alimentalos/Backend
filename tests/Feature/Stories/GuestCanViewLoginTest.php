<?php


namespace Tests\Feature\Stories;


use App\Models\Alert;
use App\Models\User;
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
