<?php


namespace Tests\Feature\Stories;


use App\Models\Geofence;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedGeofenceInOwnedGroupTest extends TestCase
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
            '/api/groups/' . $group->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $this->assertDatabaseHas('groupables', [
            'groupable_id' => $geofence->uuid,
            'groupable_type' => 'App\\Models\\Geofence',
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/geofences/' . $geofence->uuid . '/groups',
            []
        );
        $this->assertDatabaseHas('actions', [
            'resource' => 'App\\Http\\Controllers\\Resource\\Geofences\\AttachController',
            'referenced_uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }
}
