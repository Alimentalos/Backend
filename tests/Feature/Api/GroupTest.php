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
     * @test testUserCanCreateGroups
     */
    public function testUserCanCreateGroups()
    {
        // TODO - Add JsonFragment or JsonStructure assert
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups');
        $response->assertOk();
    }

    /**
     * @test testAdminWatchingGroupsList
     */
    public function testAdminWatchingGroupsList()
    {
        // TODO - Add JsonFragment or JsonStructure assert
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group);
        $user->email = 'iantorres@outlook.com';
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups');
        $response->assertOk();
    }

    /**
     * @test testUserCanShowGroupAndHisRelatedResources
     */
    public function testUserCanShowGroupAndHisRelatedResources()
    {
        // TODO - Add JsonFragment or JsonStructure assert
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->is_public = false;
        $user->groups()->attach($group);
        $group->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/pets');
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/users');
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/comments');
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
            'id' => (json_decode($content))->id,
            'user_id' => $user->id,
            'commentable_type' => 'App\\Group',
            'commentable_id' => $group->id,
            'body' => $comment->body,
        ]);
    }

    /**
     * @test testUserCanStoreGroup
     */
    public function testUserCanStoreGroup()
    {
        // TODO - Add JsonFragment or JsonStructure assert
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => $group->name,
            'is_public' => 'true',
            'coordinates' => '10.1,50.5'
        ]);
        $response->assertOk();
        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }

    /**
     * @test testChildUserCannotStoreGroup
     */
    public function testChildUserCannotStoreGroup()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_id = $user->id;
        $userB->save();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($userB, 'api')->json('POST', '/api/groups', [
            'name' => $group->name,
            'is_public' => 'false',
        ]);
        $response->assertStatus(403);
    }

    /**
     * @test testUserGroupAdministratorCanUpdateGroup
     */
    public function testUserGroupAdministratorCanUpdateGroup()
    {
        // TODO - Add DatabaseHas and JsonFragment or JsonStructure assert
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
            'resource' => 'App\\Http\\Controllers\\Api\\Groups\\UpdateController',
            'referenced_id' => $group->id,
        ]);


        $response->assertOk();
    }

    /**
     * @test testUserCanUpdateAnOwnedGroupWithPhoto
     */
    public function testUserCanUpdateAnOwnedGroupWithPhoto()
    {
        // TODO - Add DatabaseHas and JsonFragment or JsonStructure assert
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
    }

    /**
     * @test testUserCanDestroyOwnedGroup
     */
    public function testUserCanDestroyOwnedGroup()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->user_id = $user->id;
        $group->save();
        $user->groups()->attach($group, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/groups/' . $group->uuid);
        $this->assertDeleted('groups', [
            'id' => $group->id,
        ]);
        $response->assertOk();
    }

    /**
     * @test testGroupMemberUserCanViewRelatedGroupUsers
     */
    public function testGroupMemberUserCanViewRelatedGroupUsers()
    {
        // TODO - Add JsonFragment or JsonStructure assert
        $user = factory(User::class)->create();
        $member = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group, ['is_admin' => true]);
        $member->groups()->attach($group, ['is_admin' => false]);
        $response = $this->actingAs($member, 'api')->json('GET', '/api/groups/' . $group->uuid . '/users');
        $response->assertJsonCount(2, 'data');
        $response->assertOk();
    }

    /**
     * @test testGroupMemberUserCanViewRelatedGroupDevices
     */
    public function testGroupMemberUserCanViewRelatedGroupDevices()
    {
        // TODO - Add JsonFragment or JsonStructure assert
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $device = factory(Device::class)->create();
        $user->groups()->attach($group, ['is_admin' => true]);
        $device->groups()->attach($group);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/devices');
        $response->assertJsonCount(1, 'data');
        $response->assertOk();
    }

    /**
     * @test testIndexGeofencesPhotosApi
     */
    final public function testIndexGeofencesPhotosApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->geofences()->attach($geofence->id);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/geofences/' . $geofence->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
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
     * @test testIndexUsersPhotosApi
     */
    final public function testIndexUsersPhotosApi()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->users()->attach($user->id);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
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
        $photo->pets()->attach($pet->id);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
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
        $photo->groups()->attach($group->id);
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
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
