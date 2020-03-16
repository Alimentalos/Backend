<?php


namespace Tests\Feature;


use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Models\Location;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationEmitGeofenceEventsTest extends TestCase
{
    use RefreshDatabase;

    final public function testApplicationEmitGeofenceEvents()
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
                    'latitude' => 1,
                    'longitude' => 1,
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Device',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\User',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Pet',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Device',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\User',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Pet',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Device',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\User',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Pet',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Device',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\User',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Pet',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Device',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\User',
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
            'trackable_type' => 'Demency\\Relationships\\Models\\Pet',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);

        // Users tests
        $response = $this->actingAs($user, 'api')
            ->get('/api/users/' . $user->uuid . '/accesses');
        $response->assertOk();
        $this->assertDatabaseHas('accesses', [
            'accessible_id' => $user->uuid
        ]);
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
}
