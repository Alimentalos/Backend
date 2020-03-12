<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnGeofencesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewOwnedGeofences()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $user->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/geofences');
        $response->assertOk();
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
                    'pivot' => [
                        'geofenceable_id',
                        'geofenceable_type',
                        'geofence_uuid',
                    ]
                ]
            ]
        ]);
    }

}
