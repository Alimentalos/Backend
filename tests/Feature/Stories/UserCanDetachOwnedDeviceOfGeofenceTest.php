<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedDeviceOfGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachOwnedDeviceOfGeofence()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $device->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/devices/' . $device->uuid . '/geofences/' . $geofence->uuid . '/detach',
            []
        );
        $this->assertDeleted('geofenceables', [
            'geofenceable_type' => 'Demency\\Relationships\\Models\\Device',
            'geofenceable_id' => $device->uuid,
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }
}
