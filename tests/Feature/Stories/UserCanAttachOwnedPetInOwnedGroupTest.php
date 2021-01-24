<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedPetInOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachOwnedPetInOwnedGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $pet = Pet::factory()->create();
        change_instance_user($pet, $user);
        change_instance_user($group, $user);
        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/groups/' . $group->uuid . '/attach',
            []
        );
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'groupable_id' => $pet->uuid,
            'group_uuid' => $group->uuid,
        ]);
    }
}
