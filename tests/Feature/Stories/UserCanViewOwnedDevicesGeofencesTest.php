<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Geofence;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedDevicesGeofencesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testDevicesGeofencesApi
     */
    final public function testDevicesGeofencesApi()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $device->geofences()->attach($geofence);
        $geofence->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices/' . $device->uuid . '/geofences');
        $response->assertOk();

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
                    'is_public',
                    'photo_url',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                    'user' => [
                        'uuid',
                        'user_uuid',
                        'photo_uuid',
                        'name',
                        'email',
                        'email_verified_at',
                        'free',
                        'photo_url',
                        'location' => [
                            'type',
                            'coordinates',
                        ],
                        'is_public',
                        'created_at',
                        'updated_at',
                        'love_reactant_id',
                        'love_reacter_id',
                        'is_admin',
                        'is_child',
                    ] ,
                    'photo' => [
                        'location' => [
                            'type',
                            'coordinates',
                        ],
                        'uuid',
                        'user_uuid',
                        'comment_uuid',
                        'ext',
                        'photo_url',
                        'is_public',
                        'created_at',
                        'updated_at',
                        'love_reactant_id',
                    ],
                    'pivot' => [
                        'geofenceable_id',
                        'geofence_uuid',
                        'geofenceable_type'
                    ],
                    'shape' => [
                        'type',
                        'coordinates',
                    ]
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
        $response->assertJsonFragment([
            'uuid' => $geofence->uuid,
            'user_uuid' => $user->uuid,
        ]);
    }
}
