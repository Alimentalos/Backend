<?php


namespace Tests\Feature\Stories;


use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerCanDetachChildUserOfGroupsTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnerCanDetachChildUserOfGroups()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();
        $group = Group::factory()->create();
        change_instance_user($group, $user);
        change_instance_user($userB, $user);
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
            'groupable_type' => 'App\\Models\\User',
            'groupable_id' => $userB->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ATTACHED_STATUS
        ]);
    }
}
