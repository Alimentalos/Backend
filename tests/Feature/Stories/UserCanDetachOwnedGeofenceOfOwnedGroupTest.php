<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedGeofenceOfOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachOwnedGeofenceOfOwnedGroup()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        $group = Group::factory()->create();
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
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\Geofence',
            'groupable_id' => $geofence->uuid,
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }
}
