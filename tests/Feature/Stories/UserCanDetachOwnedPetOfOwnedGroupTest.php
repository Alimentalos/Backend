<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedPetOfOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachOwnedPetOfOwnedGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $pet = Pet::factory()->create();
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
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'groupable_id' => $pet->uuid,
            'group_uuid' => $group->uuid,
        ]);
    }
}
