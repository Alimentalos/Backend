<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedGeofencesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewGeofences()
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
