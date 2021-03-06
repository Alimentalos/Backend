<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewGeofencesOfOwnedPetTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewGeofencesOfOwnedPet()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $geofence = Geofence::factory()->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $pet->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/geofences');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
                    'shape' => [
                        'type',
                        'coordinates'
                    ],
                    'is_public',
                    'created_at',
                    'updated_at',
                    'pivot' => [
                        'geofenceable_id',
                        'geofenceable_type',
                        'geofence_uuid',
                    ]
                ]
            ]
        ]);
    }
}
