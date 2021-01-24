<?php


namespace Tests\Feature\Stories;


use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindAndReceiveNotFoundTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanFindAndReceiveNotFound()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
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
