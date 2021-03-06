<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedPetTokenTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedPetToken()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
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
