<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_route()
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
    public function test_login_redirection()
    {
        $response = $this->get('/api/user');
        $response->assertRedirect('login');
    }
    public function test_reset_password_constructor()
    {
        $response = $this->get('/password/reset');
        $response->assertOk();
    }

    public function test_confirm_constructor()
    {
        $response = $this->get('/password/confirm');
        $response->assertRedirect('login');
    }

    public function test_register_api()
    {
        $user = factory(User::class)->make();
        $response = $this->json('POST', '/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'is_public' => true,
        ]);
        $response->assertOk();
    }

    public function test_password_recovery_api()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/api/password-recovery', [
            'email' => $user->email,
        ]);
        $response->assertOk();
    }

    public function test_register_redirection()
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
    }

    public function test_reset_password_route()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/password/reset', [
            'email' => $user->email,
        ]);
        $response->assertStatus(302);
    }

    public function test_home_route()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/home');
        $response->assertStatus(200);
    }

    public function test_user_non_verified_home_route()
    {
        $user = factory(User::class)->create();
        $user->email_verified_at = null;
        $user->save();
        $response = $this->actingAs($user)
            ->get('/home');
        $response->assertStatus(302);
    }

    public function test_redirect_if_authenticated()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/login');
        $response->assertRedirect('home');
    }
}
