<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedPetOfOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanDetachOwnedPetOfOwnedGeofence()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $pet->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/geofences/' . $geofence->uuid . '/detach',
            []
        );
        $this->assertDeleted('geofenceables', [
            'geofenceable_id' => $pet->uuid,
            'geofenceable_type' => 'Demency\\Relationships\\Models\\Pet',
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }
}
