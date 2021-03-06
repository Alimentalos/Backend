<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\User;
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
        $response->assertJsonStructure([
            'current_page',
            'data' => [[
                'uuid',
                'user_uuid',
                'title',
                'body',
                'commentable_type',
                'commentable_id',
                'created_at',
                'updated_at',
                'love_reactant_id',
            ]],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
            'body' => $sampleCommentBody,
        ]);
    }
}
