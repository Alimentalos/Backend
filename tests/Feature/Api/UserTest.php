<?php

namespace Tests\Feature\Api;

use App\Device;
use App\Group;
use App\Location;
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
     * @test testUserCanStoreUser
     */
    public function testUserCanStoreUser()
    {
        // TODO - Add response structure asserts
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $userB = factory(User::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => $userB->name,
            'email' => $userB->email,
            'password' => $userB->password,
            'password_confirmation' => $userB->password,
            'is_public' => true,
            'coordinates' => '5.5,6.5',
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
     * @test testUserCanViewOwnUserApi
     */
    public function testUserCanViewOwnUserApi()
    {
        // TODO - Add response structure and data asserts
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/user');
        $response->assertOk();
    }

    /**
     * @test testUserCanViewUsersList
     */
    public function testUserCanViewUsersList()
    {
        // TODO - Add response structure and data asserts
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users');
        $response->assertOk();
    }

    /**
     * @test testAdministratorCanViewUsersList
     */
    public function testAdministratorCanViewUsersList()
    {
        // TODO - Add response structure and data asserts
        $user = factory(User::class)->create();
        $user->email = 'iantorres@outlook.com';
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users');
        $response->assertOk();
    }

    /**
     * @test testNonChildUserCanViewUsersList
     */
    public function testNonChildUserCanViewUsersList()
    {
        // TODO - Add response structure and data asserts
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $user->user_uuid = $userB->uuid;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users');
        $response->assertOk();
    }

    /**
     * @test testUserCanViewHisUserInUsersApi
     */
    public function testUserCanViewHisUserInUsersApi()
    {
        // TODO - Add response structure and data asserts
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid);
        $response->assertOk();
    }

    /**
     * @test testUserWatchingOtherUserWithSameOwner
     */
    public function testUserWatchingOtherUserWithSameOwner()
    {
        // TODO - Add response structure and data asserts
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $userA->uuid;
        $userB->save();
        $userC = factory(User::class)->create();
        $userC->user_uuid = $userA->uuid;
        $userC->is_public = false;
        $userC->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/users/' . $userC->uuid);
        $response->assertOk();
    }

    /**
     * @test testUserWatchingOwner
     */
    public function testUserWatchingOwner()
    {
        // TODO - Add response structure and data asserts
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $userA->uuid;
        $userB->is_public = false;
        $userB->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/users/' . $userA->uuid);
        $response->assertOk();
    }


    /**
     * @test testOwnerUserWatchingSpecificUser
     */
    public function testOwnerUserWatchingSpecificUser()
    {
        // TODO - Add response structure and data asserts
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->is_public = false;
        $userB->user_uuid = $user->uuid;
        $userB->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $userB->uuid);
        $response->assertOk();
    }

    /**
     * @test testUserCanViewNonOwnedUsers
     */
    public function testUserCanViewNonOwnedUsers()
    {
        // TODO - Add response structure asserts
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
    }


    /**
     * @test testUserCanUpdateUser
     */
    public function testUserCanUpdateUser()
    {
        // TODO - Add new name in response data and structure
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/users/' . $user->uuid, [
            'name' => 'New name',
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertOk();
    }

    /**
     * @test testUpdateUserWithPhotoApi
     */
    public function testUpdateUserWithPhotoApi()
    {
        // TODO - Add new photo was updated asserts
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
            'api_token',
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
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }

    /**
     * @test testUserCanDeleteOwnedDevice
     */
    public function testUserCanDeleteOwnedDevice()
    {
        // TODO - Add response structure asserts
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $user->uuid;
        $userB->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/users/' . $userB->uuid);
        $response->assertOk();
    }

    /**
     * @test testUserCanViewUserAvailableGroups
     */
    public function testUserCanViewUserAvailableGroups()
    {
        // TODO - Add response structure asserts
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/groups');
        $response->assertOk();
    }

    /**
     * @test testUserCanViewUserAvailableDevices
     */
    public function testUserCanViewUserAvailableDevices()
    {
        // TODO - Add response structure asserts
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/devices');
        $response->assertOk();
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
