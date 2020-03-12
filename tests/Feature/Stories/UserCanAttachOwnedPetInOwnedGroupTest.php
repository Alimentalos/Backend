<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedPetInOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanAttachOwnedPetInOwnedGroupTest()
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
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/groups/' . $group->uuid . '/attach',
            []
        );
        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\Pet',
            'groupable_id' => $pet->uuid,
            'group_uuid' => $group->uuid,
        ]);
    }
}
