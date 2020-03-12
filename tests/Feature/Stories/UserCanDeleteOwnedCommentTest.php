<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDeleteOwnedCommentTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDeleteOwnedComment()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();
        $comment->user_uuid = $user->uuid;
        $comment->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/comments/' . $comment->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
            'message' => 'Resource deleted successfully'
        ]);
        $this->assertDeleted('comments', [
            'uuid' => $comment->uuid,
        ]);
    }
}
