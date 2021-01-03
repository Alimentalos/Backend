<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanUpdatePetNameTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdatePetName()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/pets/' . $pet->uuid, [
            'name' => 'New name',
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertOk();
        $response->assertJsonFragment([
            "name" => "New name"
        ]);
        $this->assertDatabaseHas('pets', [
            'uuid' => $pet->uuid,
            'name' => 'New name'
        ]);
    }
}
