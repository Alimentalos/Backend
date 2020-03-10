<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Group;
use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanShowGroupAndHisRelatedResourcesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanShowGroupAndHisRelatedResources
     */
    final public function testUserCanShowGroupAndHisRelatedResources()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $pet = factory(Pet::class)->create();
        $sample = factory(Comment::class)->make();
        $group->is_public = false;
        $user->groups()->attach($group);
        $pet->groups()->attach($group);
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $group->comments()->create([
            'user_uuid' => $user->uuid,
            'body' => $sample->body
        ]);
        $group->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid);
        //
//        dd($response->getContent());
        $response->assertOk();
        $response->assertJsonStructure([
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
        ]);
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
        ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/pets');
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
                    'hair_color',
                    'left_eye_color',
                    'right_eye_color',
                    'size',
                    'born_at',
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
                    ],
                    'pivot' => [
                        'group_uuid',
                        'groupable_id',
                        'groupable_type',
                        'status',
                        'sender_uuid',
                        'is_admin',
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
        $response->assertJsonFragment([
            'uuid' => $pet->uuid,
        ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/users');
        $response -> assertJsonStructure([
            'current_page',
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
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'email',
                    'email_verified_at',
                    'free',
                    'photo_url',
                    'location'=>[
                        'type',
                        'coordinates'
                    ],
                    'is_public',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                    'love_reacter_id',
                    'is_admin',
                    'is_child',
                    'user',
                    'photo',
                ]
            ],
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/comments');
        $response -> assertJsonStructure([
            'current_page',
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
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'title',
                    'body',
                    'commentable_type',
                    'commentable_id',
                    'user',
                ]
            ],
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $response->assertOk();
    }
}