<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewGroupsOfOwnedPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewGroupOfPet()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $group = factory(Group::class)->create();
        $photo = factory(Photo::class)->create();

        $photo->user_uuid = $user->uuid;
        $photo->save();
        $group->photo_uuid = $photo->uuid;
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $pet->groups()->attach($group, [
            'status' => Group::ACCEPTED_STATUS
        ]);
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'groupable_id' => $pet->uuid,
            'group_uuid' => $group->uuid,
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/pets/' . $pet->uuid . '/groups',
            []
        );
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user',
                    'photo',
                    'description',
                    'is_public'
                ]
            ]
        ]);
        // Assert User UUID
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
        ]);
        // Assert Group UUID
        $response->assertJsonFragment([
            'group_uuid' => $group->uuid,
        ]);
        // Assert Photo UUID
        $response->assertJsonFragment([
            'photo_uuid' => json_decode($response->getContent())->data[0]->photo->uuid,
        ]);
    }
}
