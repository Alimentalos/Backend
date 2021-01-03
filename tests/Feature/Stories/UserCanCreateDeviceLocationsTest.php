<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateDeviceLocationsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateDeviceLocations()
    {
        $device = Device::factory()->create();
        $location = Location::factory()->make();
        $response = $this->actingAs($device, 'devices')->json('POST', '/api/device/locations', [
            'api_token' => $device->api_token,
            'device' => '{}',
            'location' => create_location_payload($location, $location->location->getLat(), $location->location->getLng())
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
