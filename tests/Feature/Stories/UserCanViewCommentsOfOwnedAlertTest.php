<?php


namespace Tests\Feature\Stories;


use App\Alert;
use App\Comment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewCommentsOfOwnedAlertTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testUserCanViewCommentsOfOwnedAlert
     */
    final public function testUserCanViewCommentsOfOwnedAlert()
    {
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $comment = factory(Comment::class)->make();

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
            'commentable_type' => 'App\\Alert',
            'commentable_id' => $alert->uuid,
            'body' => $comment->body,
        ]);

        $response->assertJsonCount(1, 'data');
    }
}
