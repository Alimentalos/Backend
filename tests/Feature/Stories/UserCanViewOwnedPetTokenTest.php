<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedPetTokenTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedPetToken()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->is_public = false;
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/token');
        $response->assertOk();
        $response->assertJsonFragment([
            'api_token' => $pet->api_token,
            'message' => 'Token retrieved successfully'
        ]);
    }
}
