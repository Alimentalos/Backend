<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedGeofenceInOwnedGroupAlternativeTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanAttachOwnedGeofenceInOwnedGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $geofence = Geofence::factory()->create();
        change_instance_user($geofence, $user);
        change_instance_user($group, $user);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/geofences/' . $geofence->uuid . '/groups/' . $group->uuid . '/attach',
            []
        );
        $this->assertDatabaseHas('groupables', [
            'groupable_id' => $geofence->uuid,
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\Geofence',
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/geofences/' . $geofence->uuid . '/groups',
            []
        );
        $response->assertOk();
    }
}
