<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewGroups extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewGroups
     */
    final public function testUserCanViewGroups()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group->uuid, [
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => true,
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups');
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
                        'email',
                        'email_verified_at',
                        'free',
                        'photo_url',
                        'location' => [
                            'type',
                            'coordinates',
                        ],
                        'is_public',
                        'created_at',
                        'updated_at',
                        'love_reactant_id',
                        'love_reacter_id',
                        'is_admin',
                        'is_child',
                    ] ,
                    'photo' => [
                        'location' => [
                            'type',
                            'coordinates',
                        ],
                        'uuid',
                        'user_uuid',
                        'comment_uuid',
                        'ext',
                        'photo_url',
                        'is_public',
                        'created_at',
                        'updated_at',
                        'love_reactant_id',
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
        ]);
    }
}
