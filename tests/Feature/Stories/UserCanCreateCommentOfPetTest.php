<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateCommentOfPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateCommentOfPet()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $comment = Comment::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/comments', [
            'body' => $comment->body
        ]);
        $response->assertOk();
        $content = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Models\\Pet',
            'commentable_id' => $pet->uuid,
            'body' => $comment->body
        ]);
    }
}
