<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewGroupsTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanViewGroupsTest()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $photo = factory(Photo::class)->create();
        $group->photo_uuid = $photo->uuid;
        $group->save();
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
