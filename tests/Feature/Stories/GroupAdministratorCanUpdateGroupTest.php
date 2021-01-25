<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Group;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupAdministratorCanUpdateGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testGroupAdministratorCanUpdateGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $photo = Photo::factory()->create();

        change_instance_user($photo, $user);
        change_instance_user($group, $user);
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
            'resource' => 'App\\Http\\Controllers\\Resource\\UpdateController',
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
