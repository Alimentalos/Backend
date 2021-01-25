<?php


namespace Tests\Feature\Stories;


use App\Models\Geofence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnGeofencesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewOwnedGeofences()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
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
