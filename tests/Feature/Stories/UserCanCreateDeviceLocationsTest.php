<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateDeviceLocationsTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanCreateDeviceLocationsTest()
    {
        $device = factory(Device::class)->create();
        $location = factory(Location::class)->make();
        $response = $this->actingAs($device, 'devices')->json('POST', '/api/device/locations', [
            'api_token' => $device->api_token,
            'device' => '{}',
            'location' => [
                'uuid' => $location->uuid,
                'coords' => [
                    'latitude' => $location->location->getLat(),
                    'longitude' => $location->location->getLng(),
                    'accuracy' => $location->accuracy,
                    'altitude' => $location->altitude,
                    'speed' => $location->speed,
                    'heading' => $location->heading,
                ],
                'odometer' => $location->odometer,
                'event' => $location->event,
                'activity' => [
                    'type' => $location->activity_type,
                    'confidence' => $location->activity_confidence,
                ],
                'battery' => [
                    'level' => $location->battery_level,
                    'is_charging' => $location->battery_is_charging,
                ],
                'is_moving' => $location->is_moving,
                'timestamp' => time(),
            ],
        ]);
        $response->assertCreated();
        $response->assertJsonFragment([
            'latitude' => $location->location->getLat(),
            'longitude' => $location->location->getLng(),
            'accuracy' => $location->accuracy,
            'altitude' => $location->altitude,
            'odometer' => $location->odometer,
            'event' => $location->event,
            'activity' => $location->activity_type,
            'confidence' => $location->activity_confidence,
            'battery' =>  round((float) $location->battery_level * 100),
            'charging' => $location->battery_is_charging,
            'moving' => $location->is_moving,
        ]);
    }
}
