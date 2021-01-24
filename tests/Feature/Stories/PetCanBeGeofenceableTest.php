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

class PetCanBeGeofenceableTest extends TestCase
{
    use RefreshDatabase;

    final public function testPetCanBeGeofenceable()
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
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
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
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'accuracy' => $secondPayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceIn::class, function ($e) use ($pet, $response) {
            return $e->model->uuid === $pet->uuid &&
                $e->location->trackable_type === 'Alimentalos\\Relationships\\Models\\Pet' &&
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
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'accuracy' => $thirdPayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceOut::class, function ($e) use ($pet, $response) {
            return $e->model->uuid === $pet->uuid &&
                $e->location->trackable_type === 'Alimentalos\\Relationships\\Models\\Pet' &&
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
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'accuracy' => $fourPayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceIn::class, function ($e) use ($pet, $response) {
            return $e->model->uuid === $pet->uuid &&
                $e->location->trackable_type === 'Alimentalos\\Relationships\\Models\\Pet' &&
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
            'trackable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'accuracy' => $fivePayload['location']['coords']['accuracy'],
        ]);
        Event::assertDispatched(GeofenceOut::class, function ($e) use ($pet, $response) {
            return $e->model->uuid === $pet->uuid &&
                $e->location->trackable_type === 'Alimentalos\\Relationships\\Models\\Pet' &&
                $e->location->trackable_id === $pet->uuid &&
                $e->location->uuid === json_decode($response->getContent())->uuid;
        });
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
}
