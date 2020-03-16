<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Models\User;
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
        $response->assertJsonStructure([
            'data' => [[
                'uuid',
                'user_uuid',
                'photo_uuid',
                'name',
                'description',
                'shape' => [
                    'type',
                    'coordinates'
                ],
                'is_public',
                'created_at',
                'updated_at',
            ]]
        ]);
    }
}
