<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\Geofence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedDeviceInOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachOwnedDeviceInOwnedGeofence()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $geofence = Geofence::factory()->create();
        change_instance_user($geofence, $user);
        change_instance_user($device, $user);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/devices/' . $device->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $response->assertOk();
        $this->assertDatabaseHas('geofenceables', [
            'geofenceable_type' => 'App\\Models\\Device',
            'geofenceable_id' => $device->uuid,
            'geofence_uuid' => $geofence->uuid,
        ]);
    }
}
