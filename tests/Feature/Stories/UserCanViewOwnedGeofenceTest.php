<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewOwnedGeofence()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $geofence->users()->attach($user->uuid);
        $response = $this->actingAs($user, 'api')->get('/api/geofences/' . $geofence->uuid);
        $response->assertJsonStructure([
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
        ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->get('/api/geofences/' . $geofence->uuid . '/users');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'email',
                    'is_admin',
                    'is_public',
                    'is_child',
                    'free',
                    'user',
                    'pivot' => [
                        'geofence_uuid',
                        'geofenceable_id',
                        'geofenceable_type',
                    ],
                ]
            ]
        ]);
    }
}
