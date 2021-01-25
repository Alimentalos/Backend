<?php


namespace Tests\Feature\Stories;


use App\Models\Geofence;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedPetOfOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanDetachOwnedPetOfOwnedGeofence()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $geofence = Geofence::factory()->create();
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
            'geofenceable_type' => 'App\\Models\\Pet',
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }
}
