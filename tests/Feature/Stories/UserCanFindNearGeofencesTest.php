<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindNearGeofencesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanFindNearGeofences()
    {
        $user = factory(User::class)->create();
        $nearGeofence = new Geofence();
        $nearGeofence->uuid = uuid();
        $nearGeofence->name = "Near Geofence";
        $nearGeofence->user_uuid = $user->uuid;
        $nearGeofence->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);
        $nearGeofence->save();

        $farGeofence = new Geofence();
        $farGeofence->uuid = uuid();
        $farGeofence->name = "Far Geofence";
        $farGeofence->user_uuid = $user->uuid;
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

}
