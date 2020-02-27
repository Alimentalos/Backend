<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Date;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserTokenRequest
     */
    public function testUserTokenRequest()
    {
        $user = factory(User::class)->create();
        $response = $this->json('GET', '/api/token', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertOk();
    }

    /**
     * @test testUnauthenticatedTokenRequest
     */
    public function testUnauthenticatedTokenRequest()
    {
        $user = factory(User::class)->create();
        $response = $this->json('GET', '/api/token', [
            'email' => $user->email,
            'password' => 'password-1'
        ]);
        $response->assertOk();
    }
}
