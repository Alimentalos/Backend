<?php


namespace Tests\Feature\Stories;


use App\Models\Group;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosOfOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPhotosOfOwnedGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $photo = Photo::factory()->create();
        $photo->groups()->attach($group->uuid);
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/photos');
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
    }
}
