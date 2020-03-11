<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedGeofenceInOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testAttachGroupsGeofencesApi
     */
    public function testAttachGroupsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $group->user_uuid = $user->uuid;
        $group->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/groups/' . $group->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $this->assertDatabaseHas('groupables', [
            'groupable_id' => $geofence->uuid,
            'groupable_type' => 'App\\Geofence',
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();

        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/geofences/' . $geofence->uuid . '/groups',
            []
        );

        $this->assertDatabaseHas('actions', [
            'resource' => 'App\\Http\\Controllers\\Api\\Resource\\Geofences\\AttachController',
            'referenced_uuid' => $group->uuid,
        ]);

        $response->assertOk();
    }
}
