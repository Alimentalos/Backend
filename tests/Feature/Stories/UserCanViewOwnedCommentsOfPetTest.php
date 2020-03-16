<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedCommentsOfPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedCommentsOfPet()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $comment = factory(Comment::class)->make();
        $pet->comments()->create([
            'user_uuid' => $user->uuid,
            'title' => $comment->title,
            'body' => $comment->body,
        ]);
        $photo->pets()->attach($pet);
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/comments');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'user',
                    'title',
                    'body',
                    'commentable_id',
                    'commentable_type',
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
            'body' => $comment->body,
            'title' => $comment->title,
        ]);
        $this->assertDatabaseHas('comments', [
            'user_uuid' => $user->uuid,
            'commentable_type' => 'Demency\\Relationships\\Models\\Pet',
            'commentable_id' => $pet->uuid,
            'body' => $comment->body,
        ]);
        $response->assertJsonCount(1, 'data');
    }
}
