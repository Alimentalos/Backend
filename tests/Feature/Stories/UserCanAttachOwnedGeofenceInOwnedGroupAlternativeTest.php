<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedGeofenceInOwnedGroupAlternativeTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanAttachOwnedGeofenceInOwnedGroup()
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
            '/api/geofences/' . $geofence->uuid . '/groups/' . $group->uuid . '/attach',
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
        $response->assertOk();
    }
}