<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedPhotosTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedPhotos()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->users()->attach($user->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/photos');
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
