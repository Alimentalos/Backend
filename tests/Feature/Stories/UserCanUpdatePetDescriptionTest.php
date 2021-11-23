<?php


namespace Tests\Feature\Stories;


use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanUpdatePetDescriptionTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdatePetDescription()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/pets/' . $pet->uuid, [
            'name' => 'New name',
            'description' => 'New description',
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertOk();
        $response->assertJsonFragment([
            'name' => 'New name',
            'description' => 'New description',
        ]);
        $this->assertDatabaseHas('pets', [
            'uuid' => $pet->uuid,
            'name' => 'New name',
            'description' => 'New description',
        ]);
    }
}
