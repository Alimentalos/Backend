<?php


namespace Tests\Feature\Stories;


use App\Models\Geofence;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildCanViewOwnerGeofencesTest extends TestCase
{
    use RefreshDatabase;

    public function testChildCanViewOwnerGeofences()
    {
        $user = User::factory()->create();
        $owner = User::factory()->create();
        $geofence = new Geofence();
        $geofence->name = "Geofence";
        $geofence->uuid = uuid();
        $geofence->shape = create_default_polygon();
        $geofence->save();
        change_instance_user($geofence, $owner);
        change_instance_user($user, $owner);
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
}
