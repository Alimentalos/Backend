<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanUpdateOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanUpdateOwnedGeofenceTest()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
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
            'created_at' => $geofence->created_at->format('Y-m-d H:i:s')
        ]);
        $response->assertJsonStructure([
            'uuid',
            'user',
            'photo'
        ]);
        $response->assertOk();
    }
}
