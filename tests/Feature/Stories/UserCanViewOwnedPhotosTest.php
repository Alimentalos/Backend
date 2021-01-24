<?php


namespace Tests\Feature\Stories;


use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedPhotosTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedPhotos()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
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
