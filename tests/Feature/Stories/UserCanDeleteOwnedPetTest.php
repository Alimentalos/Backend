<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDeleteOwnedPetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testUserCanDeleteOwnedPet
     */
    final public function testUserCanDeleteOwnedPet()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/pets/' . $pet->uuid);
        $response->assertOk();

        $this->assertDeleted('pets', [
            'uuid' => $pet->uuid,
        ]);
    }
}
