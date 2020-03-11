<?php

namespace Tests\Feature\Api;

use App\Device;
use App\Events\GeofenceIn;
use App\Events\GeofenceOut;
use App\Geofence;
use App\Group;
use App\Location;
use App\Pet;
use Illuminate\Support\Facades\Event;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class GeofenceTest extends TestCase
{
    use RefreshDatabase;


    /**
     * @test testDeviceGeofenceFeatures
     */
    final public function testDeviceGeofenceFeatures()
    {
        Event::fake();
        $device = factory(Device::class)->create();
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $geofence = new Geofence();
        $geofence->uuid = uuid();
        $geofence->name = "Geofence";
        $geofence->user_uuid = $user->uuid;
        $geofence->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
        $geofence->save();
        $device->geofences()->attach($geofence->uuid);
        $pet->geofences()->attach($geofence->uuid);
        $user->geofences()->attach($geofence->uuid);
        $location = factory(Location::class)->make();
        $location2 = factory(Location::class)->make();
        $location3 = factory(Location::class)->make();
        $location4 = factory(Location::class)->make();
        $location5 = factory(Location::class)->make();

        // data
        $firstPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location->uuid,
                'coords' => [
                    'latitude' => 20,
                    'longitude' => 20,
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
        ];

        $secondPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location2->uuid,
                'coords' => [
                    'latitude' => 5,
                    'longitude' => 5,
                    'accuracy' => $location2->accuracy,
                    'altitude' => $location2->altitude,
                    'speed' => $location2->speed,
                    'heading' => $location2->heading,
                ],
                'odometer' => $location2->odometer,
                'event' => $location2->event,
                'activity' => [
                    'type' => $location2->activity_type,
                    'confidence' => $location2->activity_confidence,
                ],
                'battery' => [
                    'level' => $location2->battery_level,
                    'is_charging' => $location2->battery_is_charging,
                ],
                'is_moving' => $location2->is_moving,
                'timestamp' => time(),
            ],
        ];

        $thirdPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location3->uuid,
                'coords' => [
                    'latitude' => 10,
                    'longitude' => 10,
                    'accuracy' => $location3->accuracy,
                    'altitude' => $location3->altitude,
                    'speed' => $location3->speed,
                    'heading' => $location3->heading,
                ],
                'odometer' => $location3->odometer,
                'event' => $location3->event,
                'activity' => [
                    'type' => $location3->activity_type,
                    'confidence' => $location3->activity_confidence,
                ],
                'battery' => [
                    'level' => $location3->battery_level,
                    'is_charging' => $location3->battery_is_charging,
                ],
                'is_moving' => $location3->is_moving,
                'timestamp' => time(),
            ],
        ];

        $fourPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location4->uuid,
                'coords' => [
                    'latitude' => 5,
                    'longitude' => 5,
                    'accuracy' => $location4->accuracy,
                    'altitude' => $location4->altitude,
                    'speed' => $location4->speed,
                    'heading' => $location4->heading,
                ],
                'odometer' => $location4->odometer,
                'event' => $location4->event,
                'activity' => [
                    'type' => $location4->activity_type,
                    'confidence' => $location4->activity_confidence,
                ],
                'battery' => [
                    'level' => $location4->battery_level,
                    'is_charging' => $location4->battery_is_charging,
                ],
                'is_moving' => $location4->is_moving,
                'timestamp' => time(),
            ],
        ];

        $fivePayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location5->uuid,
                'coords' => [
                    'latitude' => 10,
                    'longitude' => 10,
                    'accuracy' => $location5->accuracy,
                    'altitude' => $location5->altitude,
                    'speed' => $location5->speed,
                    'heading' => $location5->heading,
                ],
                'odometer' => $location5->odometer,
                'event' => $location5->event,
                'activity' => [
                    'type' => $location5->activity_type,
                    'confidence' => $location5->activity_confidence,
                ],
                'battery' => [
                    'level' => $location5->battery_level,
                    'is_charging' => $location5->battery_is_charging,
                ],
                'is_moving' => $location5->is_moving,
                'timestamp' => time(),
            ],
        ];

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
            'trackable_type' => 'App\\Device',
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
            'trackable_type' => 'App\\Device',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
            'altitude' => $secondPayload['location']['coords']['altitude'],
            'latitude' => $secondPayload['location']['coords']['latitude'],
            'longitude' => $secondPayload['location']['coords']['longitude'],
        ]);

        Event::assertDispatched(GeofenceIn::class, function ($e) use ($device, $response) {
            return $e->model->uuid === $device->uuid &&
                $e->location->trackable_type === 'App\\Device' &&
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
            'trackable_type' => 'App\\Device',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);


        Event::assertDispatched(GeofenceOut::class, function ($e) use ($device, $response) {
            return $e->model->uuid === $device->uuid &&
                $e->location->trackable_type === 'App\\Device' &&
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
            'trackable_type' => 'App\\Device',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);

        Event::assertDispatched(GeofenceIn::class, function ($e) use ($device, $response) {
            return $e->model->uuid === $device->uuid &&
                $e->location->trackable_type === 'App\\Device' &&
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
            'trackable_type' => 'App\\Device',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);

        Event::assertDispatched(GeofenceOut::class, function ($e) use ($device, $response) {
            return $e->model->uuid === $device->uuid &&
                $e->location->trackable_type === 'App\\Device' &&
                $e->location->trackable_id === $device->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        // Devices tests
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


    /**
     * @test testPetGeofenceFeatures
     */
    final public function testPetGeofenceFeatures()
    {
        Event::fake();
        $device = factory(Device::class)->create();
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $geofence = new Geofence();
        $geofence->uuid = uuid();
        $geofence->name = "Geofence";
        $geofence->user_uuid = $user->uuid;
        $geofence->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
        $geofence->save();
        $device->geofences()->attach($geofence->uuid);
        $pet->geofences()->attach($geofence->uuid);
        $user->geofences()->attach($geofence->uuid);
        $location = factory(Location::class)->make();
        $location2 = factory(Location::class)->make();
        $location3 = factory(Location::class)->make();
        $location4 = factory(Location::class)->make();
        $location5 = factory(Location::class)->make();

        // data
        $firstPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location->uuid,
                'coords' => [
                    'latitude' => 20,
                    'longitude' => 20,
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
        ];

        $secondPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location2->uuid,
                'coords' => [
                    'latitude' => 5,
                    'longitude' => 5,
                    'accuracy' => $location2->accuracy,
                    'altitude' => $location2->altitude,
                    'speed' => $location2->speed,
                    'heading' => $location2->heading,
                ],
                'odometer' => $location2->odometer,
                'event' => $location2->event,
                'activity' => [
                    'type' => $location2->activity_type,
                    'confidence' => $location2->activity_confidence,
                ],
                'battery' => [
                    'level' => $location2->battery_level,
                    'is_charging' => $location2->battery_is_charging,
                ],
                'is_moving' => $location2->is_moving,
                'timestamp' => time(),
            ],
        ];

        $thirdPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location3->uuid,
                'coords' => [
                    'latitude' => 10,
                    'longitude' => 10,
                    'accuracy' => $location3->accuracy,
                    'altitude' => $location3->altitude,
                    'speed' => $location3->speed,
                    'heading' => $location3->heading,
                ],
                'odometer' => $location3->odometer,
                'event' => $location3->event,
                'activity' => [
                    'type' => $location3->activity_type,
                    'confidence' => $location3->activity_confidence,
                ],
                'battery' => [
                    'level' => $location3->battery_level,
                    'is_charging' => $location3->battery_is_charging,
                ],
                'is_moving' => $location3->is_moving,
                'timestamp' => time(),
            ],
        ];

        $fourPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location4->uuid,
                'coords' => [
                    'latitude' => 5,
                    'longitude' => 5,
                    'accuracy' => $location4->accuracy,
                    'altitude' => $location4->altitude,
                    'speed' => $location4->speed,
                    'heading' => $location4->heading,
                ],
                'odometer' => $location4->odometer,
                'event' => $location4->event,
                'activity' => [
                    'type' => $location4->activity_type,
                    'confidence' => $location4->activity_confidence,
                ],
                'battery' => [
                    'level' => $location4->battery_level,
                    'is_charging' => $location4->battery_is_charging,
                ],
                'is_moving' => $location4->is_moving,
                'timestamp' => time(),
            ],
        ];

        $fivePayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location5->uuid,
                'coords' => [
                    'latitude' => 10,
                    'longitude' => 10,
                    'accuracy' => $location5->accuracy,
                    'altitude' => $location5->altitude,
                    'speed' => $location5->speed,
                    'heading' => $location5->heading,
                ],
                'odometer' => $location5->odometer,
                'event' => $location5->event,
                'activity' => [
                    'type' => $location5->activity_type,
                    'confidence' => $location5->activity_confidence,
                ],
                'battery' => [
                    'level' => $location5->battery_level,
                    'is_charging' => $location5->battery_is_charging,
                ],
                'is_moving' => $location5->is_moving,
                'timestamp' => time(),
            ],
        ];

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $firstPayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $firstPayload['location']['coords']['accuracy'],
            'latitude' => $firstPayload['location']['coords']['latitude'],
            'longitude' => $firstPayload['location']['coords']['longitude'],
        ]);

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $secondPayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
        ]);


        Event::assertDispatched(GeofenceIn::class, function ($e) use ($pet, $response) {
            return $e->model->uuid === $pet->uuid &&
                $e->location->trackable_type === 'App\\Pet' &&
                $e->location->trackable_id === $pet->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $thirdPayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);

        Event::assertDispatched(GeofenceOut::class, function ($e) use ($pet, $response) {
            return $e->model->uuid === $pet->uuid &&
                $e->location->trackable_type === 'App\\Pet' &&
                $e->location->trackable_id === $pet->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $fourPayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);

        Event::assertDispatched(GeofenceIn::class, function ($e) use ($pet, $response) {
            return $e->model->uuid === $pet->uuid &&
                $e->location->trackable_type === 'App\\Pet' &&
                $e->location->trackable_id === $pet->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $fivePayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);

        Event::assertDispatched(GeofenceOut::class, function ($e) use ($pet, $response) {
            return $e->model->uuid === $pet->uuid &&
                $e->location->trackable_type === 'App\\Pet' &&
                $e->location->trackable_id === $pet->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        // Pets tests
        $response = $this->actingAs($user, 'api')
            ->get('/api/geofences/' . $geofence->uuid . '/pets/accesses');
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
            ->get('/api/pets/' . $pet->uuid . '/geofences/' . $geofence->uuid . '/accesses');
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

        $response = $this->actingAs($user, 'api')
            ->get('/api/pets/' . $pet->uuid . '/accesses');
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
    }


    /**
     * @test testUserGeofenceFeatures
     */
    final public function testUserGeofenceFeatures()
    {
        Event::fake();
        $device = factory(Device::class)->create();
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $geofence = new Geofence();
        $geofence->uuid = uuid();
        $geofence->name = "Geofence";
        $geofence->user_uuid = $user->uuid;
        $geofence->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
        $geofence->save();
        $device->geofences()->attach($geofence->uuid);
        $pet->geofences()->attach($geofence->uuid);
        $user->geofences()->attach($geofence->uuid);
        $location = factory(Location::class)->make();
        $location2 = factory(Location::class)->make();
        $location3 = factory(Location::class)->make();
        $location4 = factory(Location::class)->make();
        $location5 = factory(Location::class)->make();

        // data
        $firstPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location->uuid,
                'coords' => [
                    'latitude' => 20,
                    'longitude' => 20,
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
        ];

        $secondPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location2->uuid,
                'coords' => [
                    'latitude' => 5,
                    'longitude' => 5,
                    'accuracy' => $location2->accuracy,
                    'altitude' => $location2->altitude,
                    'speed' => $location2->speed,
                    'heading' => $location2->heading,
                ],
                'odometer' => $location2->odometer,
                'event' => $location2->event,
                'activity' => [
                    'type' => $location2->activity_type,
                    'confidence' => $location2->activity_confidence,
                ],
                'battery' => [
                    'level' => $location2->battery_level,
                    'is_charging' => $location2->battery_is_charging,
                ],
                'is_moving' => $location2->is_moving,
                'timestamp' => time(),
            ],
        ];

        $thirdPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location3->uuid,
                'coords' => [
                    'latitude' => 10,
                    'longitude' => 10,
                    'accuracy' => $location3->accuracy,
                    'altitude' => $location3->altitude,
                    'speed' => $location3->speed,
                    'heading' => $location3->heading,
                ],
                'odometer' => $location3->odometer,
                'event' => $location3->event,
                'activity' => [
                    'type' => $location3->activity_type,
                    'confidence' => $location3->activity_confidence,
                ],
                'battery' => [
                    'level' => $location3->battery_level,
                    'is_charging' => $location3->battery_is_charging,
                ],
                'is_moving' => $location3->is_moving,
                'timestamp' => time(),
            ],
        ];

        $fourPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location4->uuid,
                'coords' => [
                    'latitude' => 5,
                    'longitude' => 5,
                    'accuracy' => $location4->accuracy,
                    'altitude' => $location4->altitude,
                    'speed' => $location4->speed,
                    'heading' => $location4->heading,
                ],
                'odometer' => $location4->odometer,
                'event' => $location4->event,
                'activity' => [
                    'type' => $location4->activity_type,
                    'confidence' => $location4->activity_confidence,
                ],
                'battery' => [
                    'level' => $location4->battery_level,
                    'is_charging' => $location4->battery_is_charging,
                ],
                'is_moving' => $location4->is_moving,
                'timestamp' => time(),
            ],
        ];

        $fivePayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location5->uuid,
                'coords' => [
                    'latitude' => 10,
                    'longitude' => 10,
                    'accuracy' => $location5->accuracy,
                    'altitude' => $location5->altitude,
                    'speed' => $location5->speed,
                    'heading' => $location5->heading,
                ],
                'odometer' => $location5->odometer,
                'event' => $location5->event,
                'activity' => [
                    'type' => $location5->activity_type,
                    'confidence' => $location5->activity_confidence,
                ],
                'battery' => [
                    'level' => $location5->battery_level,
                    'is_charging' => $location5->battery_is_charging,
                ],
                'is_moving' => $location5->is_moving,
                'timestamp' => time(),
            ],
        ];

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $firstPayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $firstPayload['location']['coords']['accuracy'],
            'altitude' => $firstPayload['location']['coords']['altitude'],
            'latitude' => $firstPayload['location']['coords']['latitude'],
            'longitude' => $firstPayload['location']['coords']['longitude'],
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $secondPayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
            'altitude' => $secondPayload['location']['coords']['altitude'],
            'latitude' => $secondPayload['location']['coords']['latitude'],
            'longitude' => $secondPayload['location']['coords']['longitude'],
        ]);



        Event::assertDispatched(GeofenceIn::class, function ($e) use ($user, $response) {
            return $e->model->uuid === $user->uuid &&
                $e->location->trackable_type === 'App\\User' &&
                $e->location->trackable_id === $user->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $thirdPayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);

        Event::assertDispatched(GeofenceOut::class, function ($e) use ($user, $response) {
            return $e->model->uuid === $user->uuid &&
                $e->location->trackable_type === 'App\\User' &&
                $e->location->trackable_id === $user->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $fourPayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);

        Event::assertDispatched(GeofenceIn::class, function ($e) use ($user, $response) {
            return $e->model->uuid === $user->uuid &&
                $e->location->trackable_type === 'App\\User' &&
                $e->location->trackable_id === $user->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $fivePayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);

        Event::assertDispatched(GeofenceOut::class, function ($e) use ($user, $response) {
            return $e->model->uuid === $user->uuid &&
                $e->location->trackable_type === 'App\\User' &&
                $e->location->trackable_id === $user->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });

        // Users tests
        $response = $this->actingAs($user, 'api')
            ->get('/api/users/' . $user->uuid . '/accesses');
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
            ->get('/api/users/' . $user->uuid . '/geofences/' . $geofence->uuid . '/accesses');
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
            ->get('/api/geofences/' . $geofence->uuid . '/users/accesses');
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

    /**
     * @test testDevicesGeofencesApi
     */
    final public function testDevicesGeofencesApi()
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

    /**
     * @test testGeofenceFeaturesWithEvents
     */
    final public function testGeofenceFeaturesWithEvents()
    {
        $device = factory(Device::class)->create();
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $geofence = new Geofence();
        $geofence->name = "Geofence";
        $geofence->user_uuid = $user->uuid;
        $geofence->uuid = uuid();
        $geofence->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
        $geofence->save();
        $device->geofences()->attach($geofence->uuid);
        $pet->geofences()->attach($geofence->uuid);
        $user->geofences()->attach($geofence->uuid);
        $location = factory(Location::class)->make();
        $location2 = factory(Location::class)->make();
        $location3 = factory(Location::class)->make();
        $location4 = factory(Location::class)->make();
        $location5 = factory(Location::class)->make();

        // data
        $firstPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location->uuid,
                'coords' => [
                    'latitude' => 40,
                    'longitude' => 40,
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
        ];

        $secondPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location2->uuid,
                'coords' => [
                    'latitude' => 2,
                    'longitude' => 2,
                    'accuracy' => $location2->accuracy,
                    'altitude' => $location2->altitude,
                    'speed' => $location2->speed,
                    'heading' => $location2->heading,
                ],
                'odometer' => $location2->odometer,
                'event' => $location2->event,
                'activity' => [
                    'type' => $location2->activity_type,
                    'confidence' => $location2->activity_confidence,
                ],
                'battery' => [
                    'level' => $location2->battery_level,
                    'is_charging' => $location2->battery_is_charging,
                ],
                'is_moving' => $location2->is_moving,
                'timestamp' => time(),
            ],
        ];

        $thirdPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location3->uuid,
                'coords' => [
                    'latitude' => 3,
                    'longitude' => 3,
                    'accuracy' => $location3->accuracy,
                    'altitude' => $location3->altitude,
                    'speed' => $location3->speed,
                    'heading' => $location3->heading,
                ],
                'odometer' => $location3->odometer,
                'event' => $location3->event,
                'activity' => [
                    'type' => $location3->activity_type,
                    'confidence' => $location3->activity_confidence,
                ],
                'battery' => [
                    'level' => $location3->battery_level,
                    'is_charging' => $location3->battery_is_charging,
                ],
                'is_moving' => $location3->is_moving,
                'timestamp' => time(),
            ],
        ];

        $fourPayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location4->uuid,
                'coords' => [
                    'latitude' => 4,
                    'longitude' => 4,
                    'accuracy' => $location4->accuracy,
                    'altitude' => $location4->altitude,
                    'speed' => $location4->speed,
                    'heading' => $location4->heading,
                ],
                'odometer' => $location4->odometer,
                'event' => $location4->event,
                'activity' => [
                    'type' => $location4->activity_type,
                    'confidence' => $location4->activity_confidence,
                ],
                'battery' => [
                    'level' => $location4->battery_level,
                    'is_charging' => $location4->battery_is_charging,
                ],
                'is_moving' => $location4->is_moving,
                'timestamp' => time(),
            ],
        ];

        $fivePayload = [
            'device' => '{}',
            'location' => [
                'uuid' => $location5->uuid,
                'coords' => [
                    'latitude' => 10,
                    'longitude' => 10,
                    'accuracy' => $location5->accuracy,
                    'altitude' => $location5->altitude,
                    'speed' => $location5->speed,
                    'heading' => $location5->heading,
                ],
                'odometer' => $location5->odometer,
                'event' => $location5->event,
                'activity' => [
                    'type' => $location5->activity_type,
                    'confidence' => $location5->activity_confidence,
                ],
                'battery' => [
                    'level' => $location5->battery_level,
                    'is_charging' => $location5->battery_is_charging,
                ],
                'is_moving' => $location5->is_moving,
                'timestamp' => time(),
            ],
        ];

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
            'trackable_type' => 'App\\Device',
            'accuracy' => $firstPayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $firstPayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $firstPayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $firstPayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $firstPayload['location']['coords']['accuracy'],
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
            'trackable_type' => 'App\\Device',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $secondPayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $secondPayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
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
            'trackable_type' => 'App\\Device',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $thirdPayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $thirdPayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);

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
            'trackable_type' => 'App\\Device',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $fourPayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $fourPayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);

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
            'trackable_type' => 'App\\Device',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/user/locations', $fivePayload);
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
            'trackable_id' => $user->uuid,
            'trackable_type' => 'App\\User',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);

        $response = $this->actingAs($pet, 'pets')->json('POST', '/api/pet/locations', $fivePayload);
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
            'trackable_id' => $pet->uuid,
            'trackable_type' => 'App\\Pet',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);

        // TODO Fix accesses doen't have correct details.

        // Users tests
        $response = $this->actingAs($user, 'api')
            ->get('/api/users/' . $user->uuid . '/accesses');
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
        $response->assertJsonCount(1, 'data');

        $response = $this->actingAs($user, 'api')
            ->get('/api/users/' . $user->uuid . '/geofences/' . $geofence->uuid . '/accesses');
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
        $response->assertJsonCount(1, 'data');

        $response = $this->actingAs($user, 'api')
            ->get('/api/geofences/' . $geofence->uuid . '/users/accesses');
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
        $response->assertJsonCount(1, 'data');

        // Devices tests
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
        $response->assertJsonCount(1, 'data');

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
        $response->assertJsonCount(1, 'data');

        $response = $this->actingAs($user, 'api')
            ->get('/api/geofences/' . $geofence->uuid . '/devices/accesses');
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
        $response->assertJsonCount(1, 'data');

        // Pets tests
        $response = $this->actingAs($user, 'api')
            ->get('/api/geofences/' . $geofence->uuid . '/pets/accesses');
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
        $response->assertJsonCount(1, 'data');

        $response = $this->actingAs($user, 'api')
            ->get('/api/pets/' . $pet->uuid . '/geofences/' . $geofence->uuid . '/accesses');
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

        $response = $this->actingAs($user, 'api')
            ->get('/api/pets/' . $pet->uuid . '/accesses');
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
    }

    /**
     * @test testGeofencesUpdateApi
     */
    final public function testGeofencesUpdateApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->put('/api/geofences/' . $geofence->uuid, [
            'name' => 'Nicely!',
            'shape' => [
                ['latitude' => 0, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 7],
                ['latitude' => 7, 'longitude' => 7],
                ['latitude' => 7, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 0],
            ]
        ]);
        $response->assertJsonFragment([
            'uuid' => $geofence->uuid,
            'user_uuid' => $user->uuid,
            'name' => 'Nicely!',
            'description' => null,
            'photo_uuid' => $geofence->photo_uuid,
            'shape' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [0,0],
                        [7,0],
                        [7,7],
                        [0,7],
                        [0,0]
                    ]
                ]
            ],
            'is_public' => true,
            'created_at' => $geofence->created_at->format('Y-m-d H:i:s')
        ]);
        $response->assertJsonStructure([
            'uuid',
            'user',
            'photo'
        ]);
        $response->assertOk();
    }

    /**
     * @test testGeofencesUpdateWithPhotoApi
     */
    final public function testGeofencesUpdateWithPhotoApi()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $old_uuid = $geofence->photo->uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->put('/api/geofences/' . $geofence->uuid, [
            'photo' => UploadedFile::fake()->image('photo10.jpg'),
            'name' => 'Nicely!',
            'shape' => [
                ['latitude' => 0, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 7],
                ['latitude' => 7, 'longitude' => 7],
                ['latitude' => 7, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 0],
            ],
            'is_public' => true,
            'coordinates' => '60.1,25.5'
        ]);
        $response->assertOk();
        $content = json_decode($response->getContent());
        $response->assertJsonFragment([
            'uuid' => $geofence->uuid,
            'user_uuid' => $user->uuid,
            'name' => 'Nicely!',
            'description' => null,
            'photo_uuid' => $content->photo_uuid,
            'shape' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [0,0],
                        [7,0],
                        [7,7],
                        [0,7],
                        [0,0]
                    ]
                ]
            ],
            'is_public' => true,
            'created_at' => $geofence->created_at->format('Y-m-d H:i:s'),
        ]);
        $response->assertOk();
        $this->assertFalse($content->photo->uuid === $old_uuid);
        Storage::disk('public')->assertExists('photos/' . $content->photo->photo_url);
    }

    /**
     * @test testGeofencesIndexApi
     */
    final public function testGeofencesIndexApi()
    {
        $user = factory(User::class)->create();
        $geofence = new Geofence();
        $geofence->name = "Geofence";
        $geofence->user_uuid = $user->uuid;
        $geofence->uuid = uuid();
        $geofence->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
        $geofence->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/geofences');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user',
                    'photo',
                    'name',
                    'description',
                    'shape',
                    'is_public',
                ]
            ]
        ]);
    }

    /**
     * @test testGeofencesIndexAsChildApi
     */
    public function testGeofencesIndexAsChildApi()
    {
        $user = factory(User::class)->create();
        $owner = factory(User::class)->create();
        $geofence = new Geofence();
        $geofence->name = "Geofence";
        $geofence->user_uuid = $owner->uuid;
        $geofence->uuid = uuid();
        $geofence->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
        $geofence->save();
        $user->user_uuid = $owner->uuid;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/geofences');
        $response->assertJsonStructure([
            'data' => [
                [
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
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testGeofencesStoreApi
     */
    public function testGeofencesStoreApi()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $user->save();
        $response = $this->actingAs($user, 'api')->post('/api/geofences', [
            'photo' => UploadedFile::fake()->image('photo5.jpg'),
            'name' => 'Awesome geofence!',
            'is_public' => true,
            'shape' => [
                ['latitude' => 0, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 5],
                ['latitude' => 5, 'longitude' => 5],
                ['latitude' => 5, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 0],
            ],
            'coordinates' => '20.1,25.5'
        ]);
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
            'shape' => [
                'type',
                'coordinates'
            ],
            'photo' => [
                'uuid'
            ],
            'is_public',
            'created_at',
            'updated_at',
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }

    /**
     * @test testGeofenceDestroyApi
     */
    final public function testGeofenceDestroyApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->delete('/api/geofences/' . $geofence->uuid);
        $response->assertOk();
    }

    /**
     * @test testAttachDevicesGeofencesApi
     */
    final public function testAttachDevicesGeofencesApi()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/devices/' . $device->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $response->assertOk();
        $this->assertDatabaseHas('geofenceables', [
            'geofenceable_type' => 'App\\Device',
            'geofenceable_id' => $device->uuid,
            'geofence_uuid' => $geofence->uuid,
        ]);
    }

    /**
     * @test testDetachDevicesGeofencesApi
     */
    final public function testDetachDevicesGeofencesApi()
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
            'geofenceable_type' => 'App\\Device',
            'geofenceable_id' => $device->uuid,
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }

    /**
     * @test testAttachDevicesGeofencesApi
     */
    final public function testAttachUsersGeofencesApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/users/' . $user->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $response->assertOk();
        $this->assertDatabaseHas('geofenceables', [
            'geofence_uuid' => $geofence->uuid,
            'geofenceable_type' => 'App\\User',
            'geofenceable_id' => $user->uuid,
        ]);
    }

    /**
     * @test testDetachDevicesGeofencesApi
     */
    final public function testDetachUsersGeofencesApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $user->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/users/' . $user->uuid . '/geofences/' . $geofence->uuid . '/detach',
            []
        );
        $response->assertOk();
        $this->assertDeleted('geofenceables', [
            'geofence_uuid' => $geofence->uuid,
            'geofenceable_type' => 'App\\User',
            'geofenceable_id' => $user->uuid,
        ]);
    }

    /**
     * @test testGeofencesShowApi
     */
    public function testGeofencesShowApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $geofence->users()->attach($user->uuid);
        $response = $this->actingAs($user, 'api')->get('/api/geofences/' . $geofence->uuid);
        $response->assertJsonStructure([
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
        ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->get('/api/geofences/' . $geofence->uuid . '/users');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'email',
                    'is_admin',
                    'is_public',
                    'is_child',
                    'free',
                    'user',
                    'pivot' => [
                        'geofence_uuid',
                        'geofenceable_id',
                        'geofenceable_type',
                    ],
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testAttachPetsGeofencesApi
     */
    public function testAttachPetsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $this->assertDatabaseHas('geofenceables', [
            'geofenceable_id' => $pet->uuid,
            'geofenceable_type' => 'App\\Pet',
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }

    /**
     * @test testDetachPetsGeofencesApi
     */
    public function testDetachPetsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $pet->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/geofences/' . $geofence->uuid . '/detach',
            []
        );
        $this->assertDeleted('geofenceables', [
            'geofenceable_id' => $pet->uuid,
            'geofenceable_type' => 'App\\Pet',
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }


    /**
     * @test testAttachGroupsGeofencesApi
     */
    public function testAttachGroupsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $group->user_uuid = $user->uuid;
        $group->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/groups/' . $group->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $this->assertDatabaseHas('groupables', [
            'groupable_id' => $geofence->uuid,
            'groupable_type' => 'App\\Geofence',
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();

        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/geofences/' . $geofence->uuid . '/groups',
            []
        );

        $this->assertDatabaseHas('actions', [
            'resource' => 'App\\Http\\Controllers\\Api\\Resource\\Geofences\\AttachController',
            'referenced_uuid' => $group->uuid,
        ]);

        $response->assertOk();
    }

    /**
     * @test testGeofencesGroupsApi
     */
    public function testGeofencesGroupsApi()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->geofences()->attach($geofence->uuid, [
            'status' => Group::ATTACHED_STATUS,
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/geofences/' . $geofence->uuid . '/groups/',
            []
        );
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
                    'is_public',
                    'created_at',
                    'updated_at',
                    'pivot' => [
                        'groupable_id',
                        'groupable_type',
                        'group_uuid',
                    ]
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testDetachPetsGeofencesApi
     */
    public function testDetachGroupsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/groups/' . $group->uuid . '/geofences/' . $geofence->uuid . '/detach',
            []
        );
        $this->assertDeleted('groupables', [
            'groupable_id' => $geofence->uuid,
            'groupable_type' => 'App\\Geofence',
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }

    /**
     * @test testPetsGeofencesApi
     */
    public function testPetsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $pet->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/geofences');
        $response->assertJsonStructure([
            'data' => [
                [
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
                    'pivot' => [
                        'geofenceable_id',
                        'geofenceable_type',
                        'geofence_uuid',
                    ]
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testUsersGeofencesApi
     */
    public function testUsersGeofencesApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $user->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/geofences');
        $response->assertJsonStructure([
            'data' => [
                [
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
                    'pivot' => [
                        'geofenceable_id',
                        'geofenceable_type',
                        'geofence_uuid',
                    ]
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testGroupsGeofencesApi
     */
    public function testGroupsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $geofence = factory(Geofence::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $group->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/geofences');
        $response->assertJsonStructure([
            'data' => [
                [
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
                    'pivot' => [
                        'groupable_id',
                        'groupable_type',
                        'group_uuid',
                    ]
                ]
            ]
        ]);
        $response->assertOk();
    }
}
