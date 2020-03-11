<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserCanViewAvailableGroupsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test testUserCanViewUserAvailableGroups
     */
    final public function testUserCanViewAvailableGroupsTest()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->photo_uuid = factory(Photo::class)->create()->uuid;
        $group->user_uuid = $user->uuid;
        $group->save();
        $user->groups()->attach($group->uuid, [
            'status' => Group::ACCEPTED_STATUS,
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/groups');
        $response->assertOk();

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
                    'is_public',
                    'photo_url',
                    'created_at',
                    'updated_at',
                    'user' => [
                        'uuid',
                        'user_uuid',
                        'photo_uuid',
                        'name',
                        'email_verified_at',
                        'free',
                        'photo_url',
                        'is_public',
                        'created_at',
                        'updated_at',
                        'love_reactant_id',
                        'love_reacter_id',
                        'is_admin',
                        'is_child',
                    ] ,
                    'photo' => [
                        'uuid',
                        'user_uuid',
                        'comment_uuid',
                        'ext',
                        'photo_url',
                        'is_public',
                        'created_at',
                        'updated_at',
                        'love_reactant_id',
                    ],
                    'pivot' => [
                        'groupable_id',
                        'group_uuid',
                        'groupable_type',
                        'is_admin',
                        'status',
                        'sender_uuid',
                        'created_at',
                        'updated_at',
                    ]
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
        // Assert contains the group uuid and user uuid.
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
            'user_uuid' => $user->uuid,
        ]);
    }
}
