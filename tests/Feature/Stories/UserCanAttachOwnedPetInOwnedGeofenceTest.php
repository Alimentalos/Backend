<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedPetInOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanAttachOwnedPetInOwnedGeofence()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $geofence = Geofence::factory()->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $this->assertDatabaseHas('geofenceables', [
            'geofenceable_id' => $pet->uuid,
            'geofenceable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }

}
