<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersCanDetachOwnedGeofenceOfOwnedGroupTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test testDetachPetsGeofencesApi
     */
    public function testDetachGroupsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $geofence = factory(Geofence::class)->create();
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
        $this->assertDeleted('groupables', [
            'groupable_id' => $geofence->uuid,
            'groupable_type' => 'App\\Geofence',
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }
}
