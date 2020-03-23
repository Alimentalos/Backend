<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanRegister()
    {
        $user = factory(User::class)->make();
        $password = substr(md5(mt_rand()), 0, 8);
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
            'is_public' => true,
            'country_name' => 'Maipú',
            'region_name' => 'Región metropolitana',
            'city_name' => 'Provincia de santiago',
            'city' => 10000,
            'region' => 20000,
            'country' => 30000,
        ]);
        $response->assertRedirect('home');
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }
}
