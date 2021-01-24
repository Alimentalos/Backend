<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Events\GeofenceIn;
use Alimentalos\Relationships\Events\GeofenceOut;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Location;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DevicesCanBeGeofenceableTest extends TestCase
{
    use RefreshDatabase;

    final public function testDevicesCanBeGeofenceable()
    {
        Event::fake();
        $device = Device::factory()->create();
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $geofence = new Geofence();
        $geofence->uuid = uuid();
        $geofence->name = "Geofence";
        $geofence->user_uuid = $user->uuid;
        $geofence->shape = create_default_polygon();
        $geofence->save();
        $device->geofences()->attach($geofence->uuid);
        $pet->geofences()->attach($geofence->uuid);
        $user->geofences()->attach($geofence->uuid);
        $location = Location::factory()->make();
        $location2 = Location::factory()->make();
        $location3 = Location::factory()->make();
        $location4 = Location::factory()->make();
        $location5 = Location::factory()->make();

        $firstPayload = create_location_payload($location, 20, 20);
        $secondPayload = create_location_payload($location2, 5, 5);
        $thirdPayload = create_location_payload($location3, 10, 10);
        $fourPayload = create_location_payload($location4, 5, 5);
        $fivePayload = create_location_payload($location5, 10, 10);

        $response = $this->actingAs($device, 'devices')->json('POST', '/api/device/locations', $firstPayload);
        $response->assertCreated();
        $response->assertJsonStructure([
            'uuid',
            'trackable_id',
            'trackable_type',
            'accuracy',
            'altitude',
            'latitude',
            'longitude',
            'speed',
            'odometer',
            'heading',
            'battery',
            'activity',
            'confidence',
            'moving',
            'charging',
            'event',
            'generated_at',
            'created_at',
        ]);

        $response->assertJsonFragment([
            'trackable_id' => $device->uuid,
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Device',
            'accuracy' => $firstPayload['location']['coords']['accuracy'],
            'altitude' => $firstPayload['location']['coords']['altitude'],
            'latitude' => $firstPayload['location']['coords']['latitude'],
            'longitude' => $firstPayload['location']['coords']['longitude'],
        ]);
        $response = $this->actingAs($device, 'devices')->json('POST', '/api/device/locations', $secondPayload);
        $response->assertCreated();
        $response->assertJsonStructure([
            'uuid',
            'trackable_id',
            'trackable_type',
            'accuracy',
            'altitude',
            'latitude',
            'longitude',
            'speed',
            'odometer',
            'heading',
            'battery',
            'activity',
            'confidence',
            'moving',
            'charging',
            'event',
            'generated_at',
            'created_at',
        ]);
        $response->assertJsonFragment([
            'trackable_id' => $device->uuid,
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Device',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
            'altitude' => $secondPayload['location']['coords']['altitude'],
            'latitude' => $secondPayload['location']['coords']['latitude'],
            'longitude' => $secondPayload['location']['coords']['longitude'],
        ]);
        Event::assertDispatched(GeofenceIn::class, function ($e) use ($device, $response) {
            return $e->model->uuid === $device->uuid &&
                $e->location->trackable_type === 'Alimentalos\\Relationships\\Models\\Device' &&
                $e->location->trackable_id === $device->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/locations/' . json_decode($response->getContent())->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'trackable_type',
            'trackable_id',
            'device',
            'uuid',
            'location'=>[
                'type',
                'coordinates',
            ],
            'accuracy',
            'altitude',
            'heading',
            'odometer',
            'event',
            'activity_type',
            'activity_confidence',
            'battery_level',
            'battery_is_charging',
            'is_moving',
            'generated_at',
            'created_at',
            'updated_at',
            'trackable'=> [
                'user_uuid',
                'location' => [
                    'type',
                    'coordinates',
                ],
                'uuid',
                'name',
                'description',
                'is_public',
                'created_at',
                'updated_at',
            ],
        ]);
        $response->assertJsonFragment([
            'trackable_id' => $device->uuid,
        ]);
        $response = $this->actingAs($device, 'devices')->json('POST', '/api/device/locations', $thirdPayload);
        $response->assertCreated();
        $response->assertJsonStructure([
            'uuid',
            'trackable_id',
            'trackable_type',
            'accuracy',
            'altitude',
            'latitude',
            'longitude',
            'speed',
            'odometer',
            'heading',
            'battery',
            'activity',
            'confidence',
            'moving',
            'charging',
            'event',
            'generated_at',
            'created_at',
        ]);
        $response->assertJsonFragment([
            'trackable_id' => $device->uuid,
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Device',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceOut::class, function ($e) use ($device, $response) {
            return $e->model->uuid === $device->uuid &&
                $e->location->trackable_type === 'Alimentalos\\Relationships\\Models\\Device' &&
                $e->location->trackable_id === $device->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });
        $response = $this->actingAs($device, 'devices')->json('POST', '/api/device/locations', $fourPayload);
        $response->assertCreated();
        $response->assertJsonStructure([
            'uuid',
            'trackable_id',
            'trackable_type',
            'accuracy',
            'altitude',
            'latitude',
            'longitude',
            'speed',
            'odometer',
            'heading',
            'battery',
            'activity',
            'confidence',
            'moving',
            'charging',
            'event',
            'generated_at',
            'created_at',
        ]);
        $response->assertJsonFragment([
            'trackable_id' => $device->uuid,
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Device',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceIn::class, function ($e) use ($device, $response) {
            return $e->model->uuid === $device->uuid &&
                $e->location->trackable_type === 'Alimentalos\\Relationships\\Models\\Device' &&
                $e->location->trackable_id === $device->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });
        $response = $this->actingAs($device, 'devices')->json('POST', '/api/device/locations', $fivePayload);
        $response->assertCreated();
        $response->assertJsonStructure([
            'uuid',
            'trackable_id',
            'trackable_type',
            'accuracy',
            'altitude',
            'latitude',
            'longitude',
            'speed',
            'odometer',
            'heading',
            'battery',
            'activity',
            'confidence',
            'moving',
            'charging',
            'event',
            'generated_at',
            'created_at',
        ]);
        $response->assertJsonFragment([
            'trackable_id' => $device->uuid,
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Device',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceOut::class, function ($e) use ($device, $response) {
            return $e->model->uuid === $device->uuid &&
                $e->location->trackable_type === 'Alimentalos\\Relationships\\Models\\Device' &&
                $e->location->trackable_id === $device->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });
        $response = $this->actingAs($user, 'api')
            ->get('/api/devices/' . $device->uuid . '/accesses');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'accessible',
                    'first_location',
                    'last_location',
                    'status'
                ]
            ]
        ]);
        $response->assertJsonCount(2, 'data');
        $response = $this->actingAs($user, 'api')
            ->get('/api/devices/' . $device->uuid . '/geofences/' . $geofence->uuid . '/accesses');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'accessible',
                    'first_location',
                    'last_location',
                    'status'
                ]
            ]
        ]);
        $response->assertJsonCount(2, 'data');
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/geofences/' . $geofence->uuid . '/devices/accesses');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'accessible',
                    'first_location',
                    'last_location',
                    'status'
                ]
            ]
        ]);
        $response->assertJsonCount(2, 'data');
    }
}
