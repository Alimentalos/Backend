<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
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
