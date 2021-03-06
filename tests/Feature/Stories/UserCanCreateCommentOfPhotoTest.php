<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateCommentOfPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateCommentOfPhoto()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $photo = Photo::factory()->create();
        change_instance_user($pet, $user);
        change_instance_user($photo, $user);
        $pet->photo_uuid = $photo->uuid;

        $photo->save();
        $pet->save();
        $pet->photos()->attach($photo);
        $comment = Comment::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/photos/' . $photo->uuid . '/comments', [
            'body' => $comment->body,
            'is_public' => true,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'body',
            'user_uuid',
            'commentable_id',
            'commentable_type',
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);
        $content = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'Alimentalos\\Relationships\\Models\\Photo',
            'commentable_id' => $photo->uuid,
            'body' => $comment->body,
        ]);
    }
}
