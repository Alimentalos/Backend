<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewCommentsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewComments()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $comment = factory(Comment::class)->create();
        $comment->user_uuid = $user->uuid;
        $comment->save();
        $photo->user_uuid = $user->uuid;
        $pet->user_uuid = $user->uuid;
        $pet->photo_uuid = $photo->uuid;
        $photo->comment_uuid = $comment->uuid;
        $photo->save();
        $pet->save();
        $pet->photos()->attach($photo);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . $photo->comment_uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'title',
            'body',
            'commentable_type',
            'commentable_id',
            'created_at',
            'updated_at',
            'love_reactant_id',
            'commentable',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);
    }
}
