<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedDevicesGeofencesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedDevicesGeofences()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $geofence = Geofence::factory()->create();
        $photo = Photo::factory()->create();

        $photo->user_uuid = $user->uuid;
        $photo->save();
        $geofence->user_uuid = $user->uuid;
        $geofence->photo_uuid = $photo->uuid;
        $geofence->save();
        $device->user_uuid = $user->uuid;
        $device->save();
        $device->geofences()->attach($geofence);
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
