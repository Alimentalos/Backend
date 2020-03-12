<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Geofence;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedGeofencesOfOwnedDeviceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedGeofencesOfOwnedDevice()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $device->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices/' . $device->uuid . '/geofences');
        $response->assertOk();
    }
}
