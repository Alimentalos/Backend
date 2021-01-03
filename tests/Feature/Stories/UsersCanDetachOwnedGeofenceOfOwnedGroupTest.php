<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersCanDetachOwnedGeofenceOfOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanDetachOwnedGeofenceOfOwnedGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $geofence = Geofence::factory()->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/groups/' . $group->uuid . '/geofences/' . $geofence->uuid . '/detach',
            []
        );
        $response->assertOk();
        $this->assertDeleted('groupables', [
            'groupable_id' => $geofence->uuid,
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\Geofence',
            'group_uuid' => $group->uuid,
        ]);
    }
}
