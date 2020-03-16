<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewPhotos()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_uuid = $user->uuid;
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $user->photo_uuid = $photo->uuid;
        $user->save();
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'location' =>[
                'type',
                'coordinates',
            ],
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'uuid' => $photo->uuid
        ]);
    }
}
