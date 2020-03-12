<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerCanAttachChildUserInGroupsTest extends TestCase
{
    use RefreshDatabase;

    public function OwnerCanAttachChildUserInGroupsTest()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->users()->attach($user, ['is_admin' => true, 'status' => Group::ATTACHED_STATUS]);
        $userB->user_uuid = $user->uuid;
        $userB->save();

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $userB->uuid . '/groups/' . $group->uuid . '/attach', [
                'is_admin' => false,
            ]);
        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $userB->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => false
        ]);
        $response->assertOk();
    }
}
