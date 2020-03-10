<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\Photo;
use App\User;
use Tests\TestCase;

class UserCanViewGroupPhotosTest extends TestCase
{
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
