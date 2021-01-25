<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedCommentsOfOwnedCommentTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedCommentsOfOwnedComment()
    {
        $sampleCommentBody = 'Sample comment';
        $user = User::factory()->create();
        $comment = Comment::factory()->create();
        $comment->user_uuid = $user->uuid;
        $comment->save();
        $comment->comments()->create([
            'uuid' => uuid(),
            'body' => $sampleCommentBody,
            'user_uuid' => $user->uuid,
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . $comment->uuid . '/comments');
        $response->assertOk();
        $response->assertJsonStructure(array_merge(default_pagination_fields(), ['data' => [[
            'uuid',
            'user_uuid',
            'title',
            'body',
            'commentable_type',
            'commentable_id',
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]]]));
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
            'body' => $sampleCommentBody,
        ]);
    }
}
