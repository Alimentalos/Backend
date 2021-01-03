<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDeleteOwnedPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDeleteOwnedPet()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/pets/' . $pet->uuid);
        $response->assertOk();
        $this->assertDeleted('pets', [
            'uuid' => $pet->uuid,
        ]);
    }
}
