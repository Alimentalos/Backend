<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Group;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupAdministratorCanUpdateGroupTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test testUserGroupAdministratorCanUpdateGroup
     */
    final public function testUserGroupAdministratorCanUpdateGroup()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $group->user_uuid = $user->uuid;
        $group->photo_uuid = $photo->uuid;
        $group->save();
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
        ]);
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
            'name' => 'New name',
        ]);
        $response->assertOk();
    }
}
