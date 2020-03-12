<?php


namespace Tests\Feature\Stories;


use App\User;
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
        ]);
        $response->assertCreated();
    }
}
