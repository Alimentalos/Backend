<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedGeofencesOfOwnedDeviceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedGeofencesOfOwnedDevice()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $geofence = Geofence::factory()->create();
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
