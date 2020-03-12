<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDeleteOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    public function UserCanDeleteOwnedGroupTest()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $user->groups()->attach($group, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/groups/' . $group->uuid);
        $this->assertDeleted('groups', [
            'uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }
}
