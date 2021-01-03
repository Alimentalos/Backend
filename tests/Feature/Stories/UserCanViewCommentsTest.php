<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewCommentsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewComments()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $photo = Photo::factory()->create();
        $comment = Comment::factory()->create();
        $comment->user_uuid = $user->uuid;
        $comment->save();
        $photo->user_uuid = $user->uuid;
        $pet->user_uuid = $user->uuid;
        $pet->photo_uuid = $photo->uuid;
        $photo->save();
        $pet->save();
        $pet->photos()->attach($photo);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . $comment->uuid);
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
