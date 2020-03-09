<?php

namespace Tests\Feature\Api;

use App\Comment;
use App\Device;
use App\Geofence;
use App\Group;
use App\Pet;
use App\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testGroupMemberUserCanViewRelatedGroupDevices
     */
    final public function testGroupMemberUserCanViewRelatedGroupDevices()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $device = factory(Device::class)->create();
        $user->groups()->attach($group, ['is_admin' => true]);
        $device->groups()->attach($group);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/devices');
        $response->assertJsonCount(1, 'data');
        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'location' => [
                        'type',
                        'coordinates',
                    ],
                    'name',
                    'description',
                    'is_public',
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
                        'user',
                    ] ,
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
            'uuid' => $device->uuid,
        ]);
    }

    /**
     * @test testGroupMemberUserCanViewRelatedGroupUsers
     */
    final public function testGroupMemberUserCanViewRelatedGroupUsers()
    {
        $user = factory(User::class)->create();
        $member = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group, ['is_admin' => true]);
        $member->groups()->attach($group, ['is_admin' => false]);
        $response = $this->actingAs($member, 'api')->json('GET', '/api/groups/' . $group->uuid . '/users');
        $response->assertJsonCount(2, 'data');

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
    }

    /**
     * @test testUserCanUpdateAnOwnedGroupWithPhoto
     */
    final public function testUserCanUpdateAnOwnedGroupWithPhoto()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/groups/' . $group->uuid, [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => 'New name',
            'is_public' => true,
            'coordinates' => '10.1,50.5'
        ]);
        $response->assertOk();
        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);

        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
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
                'user',
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
            'name' => 'New name',
        ]);

    }

    /**
     * @test testUserGroupAdministratorCanUpdateGroup
     */
    final public function testUserGroupAdministratorCanUpdateGroup()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/groups/' . $group->uuid, [
            'name' => 'New name'
        ]);
        $this->assertDatabaseHas('actions', [
            'resource' => 'App\\Http\\Controllers\\Api\\Resource\\UpdateController',
            'referenced_uuid' => $group->uuid,
        ]);

        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
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
                'user',
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
            'name' => 'New name',
        ]);
        $response->assertOk();
    }

    /**
     * @test testUserCanStoreGroup
     */
    final public function testUserCanStoreGroup()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => $group->name,
            'is_public' => 'true',
            'coordinates' => '10.1,50.5'
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
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
                'user',
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
            'uuid' => (json_decode($content))->uuid,
        ]);
    }

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
        $group->comments()->create([
            'user_uuid' => $user->uuid,
            'body' => $sample->body
        ]);
        $group->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid);
        //
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
                'user',
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
                        'is_child',
                        'user',
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

    /**
     * @test testAdminWatchingGroupsList
     */
    final public function testAdminWatchingGroupsList()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group);
        $user->email = 'iantorres@outlook.com';
        $user->save();
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
                        'user',
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
                        'user',
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

    /**
     * @test testIndexGeofencesPhotosApi
     */
    final public function testIndexGeofencesPhotosApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->geofences()->attach($geofence->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/geofences/' . $geofence->uuid . '/photos');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }


    /**
     * @test testUserCanCreateGroupComments
     */
    final public function testUserCanCreateGroupComments()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->is_public = false;
        $user->groups()->attach($group);
        $group->save();
        $comment = factory(Comment::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups/' . $group->uuid . '/comments', [
            'body' => $comment->body,
            'is_public' => true,
        ]);
        $response->assertOk();

        $content = $response->getContent();

        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Group',
            'commentable_id' => $group->uuid,
            'body' => $comment->body,
        ]);
    }



    /**
     * @test testChildUserCanStoreGroup
     */
    public function testChildUserCanStoreGroup()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $user->uuid;
        $userB->save();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($userB, 'api')->json('POST', '/api/groups', [
            'photo' => UploadedFile::fake()->image('photo2.jpg'),
            'name' => $group->name,
            'is_public' => 'false',
            'coordinates' => '10.1,50.5'
        ]);
        dd($response->getContent());
        $response->assertCreated();
        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }

    /**
     * @test testUserCanDestroyOwnedGroup
     */
    public function testUserCanDestroyOwnedGroup()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $user->groups()->attach($group, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/groups/' . $group->uuid);
        $this->assertDeleted('groups', [
            'uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }

    /**
     * @test testIndexUsersPhotosApi
     */
    final public function testIndexUsersPhotosApi()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->users()->attach($user->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testIndexPetsPhotosApi
     */
    final public function testIndexPetsPhotosApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->pets()->attach($pet->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testIndexGroupsPhotosApi
     */
    final public function testIndexGroupsPhotosApi()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->groups()->attach($group->uuid);
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }
}
