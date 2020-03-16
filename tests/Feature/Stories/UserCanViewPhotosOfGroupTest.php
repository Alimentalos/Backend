<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosOfGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewGroupPhotos()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $photo = factory(Photo::class)->create();
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
