<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedPetOfOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachOwnedPetOfOwnedGroup()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $pet->groups()->attach($group, [
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/groups/' . $group->uuid . '/detach',
            []
        );
        $response->assertOk();
        $this->assertDeleted('groupables', [
            'groupable_type' => 'Demency\\Relationships\\Models\\Pet',
            'groupable_id' => $pet->uuid,
            'group_uuid' => $group->uuid,
        ]);
    }
}
