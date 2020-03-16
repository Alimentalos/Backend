<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanBeDetachedOfOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanBeDetachedOfOwnedGeofence()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
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
            'geofenceable_type' => 'Demency\\Relationships\\Models\\User',
            'geofenceable_id' => $user->uuid,
        ]);
    }
}
