<?php


namespace Tests\Feature\Stories;


use App\Models\Geofence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanUpdateOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdateOwnedGeofence()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
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
        $response->assertOk();
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
            'created_at' => $geofence->created_at
        ]);
        $response->assertJsonStructure([
            'uuid',
            'user',
            'photo'
        ]);
    }
}
