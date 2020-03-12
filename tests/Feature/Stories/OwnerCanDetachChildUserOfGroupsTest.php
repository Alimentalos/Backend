<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerCanDetachChildUserOfGroupsTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnerCanDetachChildUserOfGroups()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $group->user_uuid = $user->uuid;
        $group->save();

        $userB->user_uuid = $user->uuid;
        $userB->save();

        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS,
        ]);
        $userB->groups()->attach($group, [
            'is_admin' => false,
            'status' => Group::ACCEPTED_STATUS,
        ]);


        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $userB->uuid . '/groups/' . $group->uuid . '/detach', []);

        $response->assertOk();

        $this->assertDeleted('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $userB->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ATTACHED_STATUS
        ]);

        $response->assertOk();
    }
}
