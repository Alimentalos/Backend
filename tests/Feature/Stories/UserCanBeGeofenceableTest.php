<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use Alimentalos\Relationships\Events\GeofenceIn;
use Alimentalos\Relationships\Events\GeofenceOut;
use App\Models\Geofence;
use App\Models\Location;
use App\Models\Pet;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserCanBeGeofenceableTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanBeGeofenceable()
    {
        Event::fake();
        $device = Device::factory()->create();
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        change_instance_user($pet, $user);
        change_instance_user($device, $user);
        $geofence = new Geofence();
        $geofence->uuid = uuid();
        $geofence->name = "Geofence";
        $geofence->shape = create_default_polygon();
        change_instance_user($geofence, $user);
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
            'trackable_type' => 'App\\Models\\User',
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
            'trackable_type' => 'App\\Models\\User',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
            'altitude' => $secondPayload['location']['coords']['altitude'],
            'latitude' => $secondPayload['location']['coords']['latitude'],
            'longitude' => $secondPayload['location']['coords']['longitude'],
        ]);
        Event::assertDispatched(GeofenceIn::class, function ($e) use ($user, $response) {
            return $e->model->uuid === $user->uuid &&
                $e->location->trackable_type === 'App\\Models\\User' &&
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
            'trackable_type' => 'App\\Models\\User',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceOut::class, function ($e) use ($user, $response) {
            return $e->model->uuid === $user->uuid &&
                $e->location->trackable_type === 'App\\Models\\User' &&
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
            'trackable_type' => 'App\\Models\\User',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceIn::class, function ($e) use ($user, $response) {
            return $e->model->uuid === $user->uuid &&
                $e->location->trackable_type === 'App\\Models\\User' &&
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
            'trackable_type' => 'App\\Models\\User',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceOut::class, function ($e) use ($user, $response) {
            return $e->model->uuid === $user->uuid &&
                $e->location->trackable_type === 'App\\Models\\User' &&
                $e->location->trackable_id === $user->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });
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
