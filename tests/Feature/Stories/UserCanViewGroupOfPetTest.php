<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewGroupOfPetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewThePetGroups
     */
    final public function testUserCanViewThePetGroups()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $group = factory(Group::class)->create();
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
            'groupable_type' => 'App\\Pet',
            'groupable_id' => $pet->uuid,
            'group_uuid' => $group->uuid,
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/pets/' . $pet->uuid . '/groups',
            []
        );
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
            'uuid' => $user->uuid,
        ]);
        // Assert Group UUID
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
        ]);
        // Assert Photo UUID
        $response->assertJsonFragment([
            'uuid' => json_decode($response->getContent())->data[0]->photo->uuid,
        ]);
        $response->assertOk();
    }
}