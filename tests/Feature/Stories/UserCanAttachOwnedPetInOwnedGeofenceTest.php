<?php


namespace Tests\Feature\Stories;


use App\Models\Geofence;
use App\Models\Pet;
use App\Models\User;
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
        change_instance_user($geofence, $user);
        change_instance_user($pet, $user);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $this->assertDatabaseHas('geofenceables', [
            'geofenceable_id' => $pet->uuid,
            'geofenceable_type' => 'App\\Models\\Pet',
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }

}
