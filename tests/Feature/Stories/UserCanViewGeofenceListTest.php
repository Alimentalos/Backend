<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewGeofenceListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewGeofenceList
     */
    final public function testUserCanViewGeofenceList()
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
}
