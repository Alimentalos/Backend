<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Events\GeofenceIn;
use App\Events\GeofenceOut;
use App\Geofence;
use App\Location;
use App\Pet;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserCanBeGeofenceableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanBeGeofenceable
     */
    final public function testUserCanBeGeofenceable()
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
}
