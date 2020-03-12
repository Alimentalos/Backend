<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindAndReceiveNotFoundTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanFindAndReceiveNotFound()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $responsePets = $this->actingAs($user, 'api')->json('GET', '/api/find', [
            'api_token' => $user->api_token,
            'type' => 'pets',
            'identifiers' => [$pet->uuid],
            'accuracy' => 100,
        ]);
        $responsePets->assertOk();
        $responsePets->assertExactJson([]);
    }
}
