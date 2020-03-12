<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function GuestCanRegisterTest()
    {
        $user = factory(User::class)->make();
        $password = substr(md5(mt_rand()), 0, 8);
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
            'is_public' => true,
        ]);
        $response->assertRedirect('home');
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }
}
