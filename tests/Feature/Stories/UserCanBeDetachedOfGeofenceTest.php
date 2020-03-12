<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanBeDetachedOfGeofenceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testUserCanBeDetachedOfGeofence
     */
    final public function testUserCanBeDetachedOfGeofence()
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
            'geofenceable_type' => 'App\\User',
            'geofenceable_id' => $user->uuid,
        ]);
    }
}
