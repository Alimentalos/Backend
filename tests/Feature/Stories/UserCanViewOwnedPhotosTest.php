<?php


namespace Tests\Feature\Stories;


use App\Photo;
use App\User;
use Tests\TestCase;

class UserCanViewOwnedPhotosTest extends TestCase
{
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
}
