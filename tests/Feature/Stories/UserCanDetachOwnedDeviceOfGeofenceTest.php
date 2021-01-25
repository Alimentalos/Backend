<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\Geofence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedDeviceOfGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachOwnedDeviceOfGeofence()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $geofence = Geofence::factory()->create();
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
            'geofenceable_type' => 'App\\Models\\Device',
            'geofenceable_id' => $device->uuid,
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }
}
