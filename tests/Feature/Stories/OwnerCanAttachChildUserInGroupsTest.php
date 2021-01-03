<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerCanAttachChildUserInGroupsTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnerCanAttachChildUserInGroups()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();
        $group = Group::factory()->create();
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
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'groupable_id' => $userB->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => false
        ]);
    }
}
