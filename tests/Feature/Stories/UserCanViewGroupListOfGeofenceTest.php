<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\Group;
use App\User;
use Tests\TestCase;

class UserCanViewGroupListOfGeofenceTest extends TestCase
{
    /**
     * testUserCanViewGroupListOfGeofence
     */
    public function testUserCanViewGroupListOfGeofence()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->geofences()->attach($geofence->uuid, [
            'status' => Group::ATTACHED_STATUS,
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/geofences/' . $geofence->uuid . '/groups/',
            []
        );
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
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
        $response->assertOk();
    }
}
