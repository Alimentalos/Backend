<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanBeAttachedInOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanBeAttachedInOwnedGeofence()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/users/' . $user->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $response->assertOk();
        $this->assertDatabaseHas('geofenceables', [
            'geofence_uuid' => $geofence->uuid,
            'geofenceable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'geofenceable_id' => $user->uuid,
        ]);
    }
}
