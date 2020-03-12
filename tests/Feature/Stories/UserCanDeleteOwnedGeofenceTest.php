<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\User;
use Tests\TestCase;

class UserCanDeleteOwnedGeofenceTest extends TestCase
{
    /**
     * @test testUserCanDeleteOwnedGeofence
     */
    final public function testUserCanDeleteOwnedGeofence()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->delete('/api/geofences/' . $geofence->uuid);
        $response->assertOk();
    }
}
