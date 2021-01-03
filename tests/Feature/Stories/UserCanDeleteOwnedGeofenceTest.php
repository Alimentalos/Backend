<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDeleteOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDeleteOwnedGeofence()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->delete('/api/geofences/' . $geofence->uuid);
        $response->assertOk();
    }
}
