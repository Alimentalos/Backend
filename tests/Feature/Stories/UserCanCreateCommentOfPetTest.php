<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateCommentOfPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateCommentOfPet()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $comment = factory(Comment::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/comments', [
            'body' => $comment->body
        ]);
        $response->assertOk();
        $content = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'Demency\\Relationships\\Models\\Pet',
            'commentable_id' => $pet->uuid,
            'body' => $comment->body
        ]);
    }
}
