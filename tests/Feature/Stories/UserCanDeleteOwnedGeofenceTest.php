<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDeleteOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanDeleteOwnedGeofenceTest()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->delete('/api/geofences/' . $geofence->uuid);
        $response->assertOk();
    }
}
