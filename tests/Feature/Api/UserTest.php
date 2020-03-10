<?php

namespace Tests\Feature\Api;

use App\Device;
use App\Group;
use App\Location;
use App\Photo;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewUserAvailableDevices
     */
    final public function testUserCanViewUserAvailableDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/devices');
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
            'user_uuid' => $user->uuid,
        ]);
    }

    /**
     * @test testUserCanDeleteOwnedDevice
     */
    final public function testUserCanDeleteOwnedDevice()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $user->uuid;
        $userB->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/users/' . $userB->uuid);
        $response->assertOk();

        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
           'message' => 'Resource deleted successfully'
        ]);
    }
    /**
     * @test testUpdateUserWithPhotoApi
     */
    final public function testUpdateUserWithPhotoApi()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/users/' . $user->uuid, [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => 'New name',
            'is_public' => true,
            'coordinates' => '5.5,6.5',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'location',
            'photo_uuid',
            'name',
            'email',
            'email_verified_at',
            'free',
            'photo_url',
            'photo' => [
                'uuid',
                'ext',
                'is_public'
            ]
        ]);
        $content = $response->getContent();
        $this->assertTrue((json_decode($content))->photo_url !== $user->photo_url);
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }

    /**
     * @test testUserCanUpdateUser
     */
    final public function testUserCanUpdateUser()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/users/' . $user->uuid, [
            'name' => 'New name',
            'coordinates' => '5.5,6.5',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => 'New name',
            'email' => $user->email,
        ]);
    }

    /**
     * @test testUserCanViewNonOwnedUsers
     */
    final public function testUserCanViewNonOwnedUsers()
    {
        $user = factory(User::class)->create();
        $userC = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userC->is_public = false;
        $userB->user_uuid = $user->uuid;
        $userC->user_uuid = $user->uuid;
        $userB->save();
        $userC->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/users/' . $userC->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $userC->name,
            'email' => $userC->email,
        ]);
    }

    /**
     * @test testOwnerUserWatchingSpecificUser
     */
    final public function testOwnerUserWatchingSpecificUser()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->is_public = false;
        $userB->user_uuid = $user->uuid;
        $userB->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $userB->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $userB->name,
            'email' => $userB->email,
        ]);
    }

    /**
     * @test testUserWatchingOwner
     */
    final public function testUserWatchingOwner()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $userA->uuid;
        $userB->is_public = false;
        $userB->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/users/' . $userA->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $userA->name,
            'email' => $userA->email,
        ]);
    }

    /**
     * @test testUserWatchingOtherUserWithSameOwner
     */
    final public function testUserWatchingOtherUserWithSameOwner()
    {
        $owner = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $owner->uuid;
        $userB->save();
        $userC = factory(User::class)->create();
        $userC->photo_uuid = factory(Photo::class)->create()->uuid;
        $userC->user_uuid = $owner->uuid;
        $userC->is_public = false;
        $userC->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/users/' . $userC->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'photo' => [
                'location' => [
                    'type',
                    'coordinates'
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
            'user' => [
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
            ],
            'uuid',
            'user_uuid',
            'photo_uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $userC->name,
            'email' => $userC->email,
        ]);
    }

    /**
     * @test testUserCanViewHisUserInUsersApi
     */
    final public function testUserCanViewHisUserInUsersApi()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
    /**
     * @test testNonChildUserCanViewUsersList
     */
    final public function testNonChildUserCanViewUsersList()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $user->user_uuid = $userB->uuid;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users');
        $response->assertOk();
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
    }
    /**
     * @test testAdministratorCanViewUsersList
     */
    final public function testAdministratorCanViewUsersList()
    {
        $user = factory(User::class)->create();
        $user->email = 'iantorres@outlook.com';
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users');
        $response->assertOk();
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
    }
    /**
     * @test testUserCanViewUsersList
     */
    final public function testUserCanViewUsersList()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users');
        $response->assertOk();
        $response->assertJsonStructure([
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
    }

    /**
     * @test testUserCanViewOwnUserApi
     */
    final public function testUserCanViewOwnUserApi()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/user');
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * @test testUserCanStoreUser
     */
    final public function testUserCanStoreUser()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $userB = factory(User::class)->make();
        $latitude = rand(1,5);
        $longitude = rand(4,10);
        $coordinates = $latitude . ',' . $longitude;
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => $userB->name,
            'email' => $userB->email,
            'password' => $userB->password,
            'password_confirmation' => $userB->password,
            'is_public' => true,
            'coordinates' => $coordinates,
        ]);
        $response->assertJsonStructure([
            'user_uuid',
            'photo_uuid',
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child',
            'photo' => [
                'location' => [
                    'type',
                    'coordinates'
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
            'user' => [
                'uuid',
                'user_uuid',
                'photo_uuid',
                'photo_url',
                'name',
                'email',
                'is_public',
                'location' => [
                    'type',
                    'coordinates'
                ],
                'love_reacter_id',
                'love_reactant_id',
                'updated_at',
                'created_at',
                'is_admin',
                'is_child',
            ]
        ]);
        $response->assertJsonFragment([
            'name' => $userB->name,
            'email' => $userB->email,
            'is_public' => true,
        ]);
        $response->assertJsonFragment([
            'coordinates' => [
                $longitude,
                $latitude,
            ],
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }

    /**
     * @test testUserCanInvitePublicUserToOwnedGroups
     */
    public function testUserCanInvitePublicUserToOwnedGroups()
    {
        $user = factory(User::class)->create();
        $acceptedUser = factory(User::class)->create();
        $rejectedUser = factory(User::class)->create();
        $blockedUser = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->users()->attach($user, ['is_admin' => true, 'status' => Group::ACCEPTED_STATUS]);
        $acceptedUser->is_public = true;
        $rejectedUser->is_public = true;
        $blockedUser->is_public = true;
        $acceptedUser->save();
        $rejectedUser->save();
        $blockedUser->save();

        // Accepted user case

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $acceptedUser->uuid  . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $acceptedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::PENDING_STATUS
        ]);

        $response = $this->actingAs($acceptedUser, 'api')
            ->json('POST', '/api/users/' . $acceptedUser->uuid . '/groups/' . $group->uuid . '/accept', [
                'is_admin' => true,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $acceptedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ACCEPTED_STATUS
        ]);

        // Rejected user case

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $rejectedUser->uuid . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $rejectedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::PENDING_STATUS
        ]);

        $response = $this->actingAs($rejectedUser, 'api')
            ->json('POST', '/api/users/' . $rejectedUser->uuid . '/groups/' . $group->uuid . '/reject', [
                'is_admin' => true,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $rejectedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::REJECTED_STATUS
        ]);

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $rejectedUser->uuid . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);

        $response->assertOk();

        $response = $this->actingAs($rejectedUser, 'api')
            ->json('POST', '/api/users/' . $rejectedUser->uuid  . '/groups/' . $group->uuid . '/accept', [
                'is_admin' => true,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $rejectedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ACCEPTED_STATUS
        ]);

        // Blocked user case

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $blockedUser->uuid . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $blockedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::PENDING_STATUS
        ]);

        $response = $this->actingAs($blockedUser, 'api')
            ->json('POST', '/api/users/' . $blockedUser->uuid . '/groups/' . $group->uuid . '/block', [
                'is_admin' => true,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $blockedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::BLOCKED_STATUS
        ]);

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $blockedUser->uuid . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);

        $response->assertStatus(403);
    }


    /**
     * @test testOwnerUserCanAttachChildUserOwnedGroups
     */
    public function testOwnerUserCanAttachChildUserOwnedGroups()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->users()->attach($user, ['is_admin' => true]);
        $userB->user_uuid = $user->uuid;
        $userB->save();

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $userB->uuid . '/groups/' . $group->uuid . '/attach', [
                'is_admin' => false,
            ]);
        $response->assertOk();

        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $userB->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => false
        ]);
        $response->assertOk();
    }

    /**
     * @test testOwnerUserCanDetachChildUserOwnedGroups
     */
    public function testOwnerUserCanDetachChildUserOwnedGroups()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $group->user_uuid = $user->uuid;
        $group->save();

        $userB->user_uuid = $user->uuid;
        $userB->save();

        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS,
        ]);
        $userB->groups()->attach($group, [
            'is_admin' => false,
            'status' => Group::ACCEPTED_STATUS,
        ]);


        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $userB->uuid . '/groups/' . $group->uuid . '/detach', []);

        $response->assertOk();

        $this->assertDeleted('groupables', [
            'groupable_type' => 'App\\User',
            'groupable_id' => $userB->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ATTACHED_STATUS
        ]);

        $response->assertOk();
    }
}
