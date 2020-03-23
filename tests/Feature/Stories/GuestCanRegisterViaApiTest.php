<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanRegisterViaApiTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanRegisterViaApi()
    {
        $user = factory(User::class)->make();
        $response = $this->json('POST', '/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'is_public' => true,
            'country_name' => 'Maipú',
            'region_name' => 'Región metropolitana',
            'city_name' => 'Provincia de santiago',
            'city' => 10000,
            'region' => 20000,
            'country' => 30000,
        ]);
        $response->assertCreated();
    }
}
