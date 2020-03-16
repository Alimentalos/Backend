<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Location;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanFindPet()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->locations()->saveMany(
            factory(Location::class, 10)->make()
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
