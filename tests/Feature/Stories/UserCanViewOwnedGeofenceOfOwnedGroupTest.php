<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedGeofenceOfOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewOwnedGeofenceOfOwnedGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $geofence = Geofence::factory()->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $group->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/geofences');
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
                        'groupable_id',
                        'groupable_type',
                        'group_uuid',
                    ]
                ]
            ]
        ]);
    }
}
