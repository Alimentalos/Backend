<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedCommentsOfAlertTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedCommentsOfAlert()
    {
        $user = User::factory()->create();
        $alert = Alert::factory()->create();
        $comment = Comment::factory()->make();
        $alert->comments()->create([
            'user_uuid' => $user->uuid,
            'title' => $comment->title,
            'body' => $comment->body,
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/alerts/' . $alert->uuid . '/comments');
        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'title',
                    'body',
                    'commentable_type',
                    'commentable_id',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
            'body' => $comment->body,
            'title' => $comment->title,
        ]);
        $this->assertDatabaseHas('comments', [
            'user_uuid' => $user->uuid,
            'commentable_type' => 'Alimentalos\\Relationships\\Models\\Alert',
            'commentable_id' => $alert->uuid,
            'body' => $comment->body,
        ]);
        $response->assertJsonCount(1, 'data');
    }
}
