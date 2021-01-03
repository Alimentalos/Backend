<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Location;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanFindPet()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $pet->locations()->saveMany(
            Location::factory(10)->make()
        );
        $responsePets = $this->actingAs($user, 'api')->json('GET', '/api/find', [
            'api_token' => $user->api_token,
            'type' => 'pets',
            'identifiers' => [$pet->uuid],
            'accuracy' => 100,
        ]);
        $responsePets->assertOk();
        $responsePets->assertJsonStructure([
            [
                'trackable_id',
                'trackable_type',
                'uuid',
                'accuracy',
                'longitude',
                'latitude',
                'created_at'
            ]
        ]);
    }
}
