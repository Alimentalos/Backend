<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanBeDetachedOfOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanBeDetachedOfOwnedGeofence()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $user->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/users/' . $user->uuid . '/geofences/' . $geofence->uuid . '/detach',
            []
        );
        $response->assertOk();
        $this->assertDeleted('geofenceables', [
            'geofence_uuid' => $geofence->uuid,
            'geofenceable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'geofenceable_id' => $user->uuid,
        ]);
    }
}
