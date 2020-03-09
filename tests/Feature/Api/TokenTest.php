<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Date;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

use Mockery;
use Tymon\JWTAuth\Blacklist;
use Tymon\JWTAuth\Claims\Collection;
use Tymon\JWTAuth\Claims\Expiration;
use Tymon\JWTAuth\Claims\IssuedAt;
use Tymon\JWTAuth\Claims\Issuer;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\Claims\NotBefore;
use Tymon\JWTAuth\Claims\Subject;
use Tymon\JWTAuth\Contracts\Providers\Storage;
use Tymon\JWTAuth\Payload;
use Tymon\JWTAuth\Validators\PayloadValidator;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Tymon\JWTAuth\Contracts\Providers\Storage|\Mockery\MockInterface
     */
    protected $storage;

    /**
     * @var \Tymon\JWTAuth\Blacklist
     */
    protected $blacklist;

    /**
     * @var \Mockery\MockInterface|\Tymon\JWTAuth\Validators\Validator
     */
    protected $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->storage = Mockery::mock(Storage::class);
        $this->blacklist = new Blacklist($this->storage);
        $this->validator = Mockery::mock(PayloadValidator::class);
    }

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
        $response = $this->get('/api/logout?token='. $token);
        $response->assertOk();

        $response = $this->json('GET', '/api/user?token=' . $token);
        // TODO There not reason to respond ok
        // @body
        $response->assertUnauthorized();

        $response = $this->json('GET', '/api/user?token=' . $refreshed);
        // TODO There not reason to respond ok
        // @body
        $response->assertOk();
        //
//        $response->assertOk();
    }

    /**
     * @test testLogout
     */
    public function testLogout()
    {
        $user = factory(User::class)->create();
        $token = \JWTAuth::fromUser( $user );
        $response = $this->json('GET', '/api/logout?token=' . $token);
        $response->assertOk();

        $response = $this->json('GET', '/api/user?token=' . $token);
        $response->assertUnauthorized();
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
     * @test testInvalidateToken
     */
    public function testInvalidateToken()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', '/api/token', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
        $token = json_decode($response->getContent())->access_token;

        $response = $this->get('/api/logout');
        $response->assertOk();
        $response->assertExactJson([
            'message' => 'Token invalidated successfully'
        ]);

        $response = $this->json('GET', '/api/user?token=' . $token);

        $response->assertUnauthorized();
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

        $response = $this->get('/api/refresh');
        $response->assertOk();

        $response = $this->json('POST', '/api/token', [
            'email' => $user->email,
            'password' => 'password-1'
        ]);

        $response->assertJsonMissing([
            'access_token' => $token
        ]);
        $response = $this->get('/api/logout');
        $response->assertOk();
        $response = $this->json('GET', '/api/user?token=' . $token);
        $response->assertUnauthorized();
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
