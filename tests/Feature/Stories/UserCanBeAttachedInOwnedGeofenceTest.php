<?php


namespace Tests\Feature\Stories;


use App\Models\Geofence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanBeAttachedInOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanBeAttachedInOwnedGeofence()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        change_instance_user($geofence, $user);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/users/' . $user->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $response->assertOk();
        $this->assertDatabaseHas('geofenceables', [
            'geofence_uuid' => $geofence->uuid,
            'geofenceable_type' => 'App\\Models\\User',
            'geofenceable_id' => $user->uuid,
        ]);
    }
}
