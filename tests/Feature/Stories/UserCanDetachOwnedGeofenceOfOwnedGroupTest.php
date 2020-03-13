<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Geofence;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedGeofenceOfOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachOwnedGeofenceOfOwnedGroup()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $geofence->groups()->attach($group, [
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/geofences/' . $geofence->uuid . '/groups/' . $group->uuid . '/detach',
            []
        );
        $response->assertExactJson(['message' => 'Resource detached to group successfully']);
        $this->assertDeleted('groupables', [
            'groupable_type' => 'App\\Geofence',
            'groupable_id' => $geofence->uuid,
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }
}