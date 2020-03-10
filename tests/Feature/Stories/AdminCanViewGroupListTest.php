<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Group;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCanViewGroupListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testAdminWatchingGroupsList
     */
    final public function testAdminWatchingGroupsList()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $group->photo_uuid = $photo->uuid;
        $group->user_uuid = $user->uuid;
        $user->groups()->attach($group, [
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => false,
        ]);
        $user->email = 'iantorres@outlook.com';
        $group->save();
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups');
        $response->assertOk();
//        dd(json_decode($response->getContent()));
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
