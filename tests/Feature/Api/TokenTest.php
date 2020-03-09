<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testInvalidRefreshedToken
     */
    public function testInvalidRefreshedToken()
    {
        $user = factory(User::class)->create();
        $token = \JWTAuth::fromUser( $user );
        $response = $this->json('GET', '/api/refresh?token=' . $token);
        $response->assertOk();
        $refreshed = json_decode($response->getContent())->access_token;
        $response = $this->get('/api/logout?token='. $token); // Invalidate first token
        $response->assertOk();

        $response = $this->json('GET', '/api/user?token=' . $refreshed);
        $response->assertOk();

        $response = $this->json('GET', '/api/user?token=' . $token);
        // TODO There not reason to respond ok
        // @body Token has been invalidate by L25
        $response->assertUnauthorized();
        dd($response->getContent());
    }

    /**
     * @test testUnauthorizedToken
     */
    public function testUnauthorizedToken()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer invalid api token",
        ])->json('GET', '/api/user');

        $response->assertUnauthorized();
    }

    /**
     * @test testUserRetrieveToken
     */
    public function testUserRetrieveToken()
    {
        $user = factory(User::class)->create();
        $token = \JWTAuth::fromUser( $user );
        $response = $this->json('GET', '/api/user?token=' . $token);
        $response->assertOk();
        $response->assertJsonFragment([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * @test testAuthorizedToken
     */
    public function testAuthorizedToken()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/api/token', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
        $response->assertOk();
    }

    /**
     * @test testRefreshToken
     */
    public function testRefreshToken()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/api/token', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);

        $token = json_decode($response->getContent())->access_token;

        $response = $this->get('/api/refresh?token=' . $token);

        $response->assertOk();

        $response = $this->json('POST', '/api/token', [
            'email' => $user->email,
            'password' => 'password-1'
        ]);

        $response->assertJsonMissing([
            'access_token' => $token
        ]);
    }

    /**
     * @test testUnauthenticatedToken
     */
    public function testUnauthenticatedToken()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/api/token', [
            'email' => $user->email,
            'password' => 'password-1'
        ]);
        $response->assertUnauthorized();
    }
}
