<?php

namespace Tests\Feature\Api;

use App\Geofence;
use App\Pet;
use App\Repositories\UniqueNameRepository;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class NearTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testNearGeofences
     */
    public function testNearGeofences()
    {
        $user = factory(User::class)->create();
        $nearGeofence = new Geofence();
        $nearGeofence->uuid = UniqueNameRepository::createIdentifier();
        $nearGeofence->name = "Near Geofence";
        $nearGeofence->user_id = $user->id;
        $nearGeofence->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
        $nearGeofence->save();

        $farGeofence = new Geofence();
        $farGeofence->uuid = UniqueNameRepository::createIdentifier();
        $farGeofence->name = "Far Geofence";
        $farGeofence->user_id = $user->id;
        $farGeofence->shape = new Polygon([new LineString([
            new Point(50, 50),
            new Point(50, 55),
            new Point(55, 55),
            new Point(55, 50),
            new Point(50, 50)
        ])]);
        $farGeofence->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/near/geofences', [
            'coordinates' => '5.1,5.3'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'shape',
                    'name',
                    'is_public',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    /**
     * @test testNearPets
     */
    public function testNearPets()
    {
        $user = factory(User::class)->create();
        $pets = factory(Pet::class, 50)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/near/pets', [
            'coordinates' => '5.1,5.3'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'location',
                    'name',
                    'is_public',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    /**
     * @test testNearPets
     */
    public function testNearUsers()
    {
        $user = factory(User::class)->create();
        $users = factory(User::class, 50)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/near/users', [
            'coordinates' => '5.1,5.3'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'name',
                    'is_public',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
