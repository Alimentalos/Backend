<?php


namespace Tests\Feature\Stories;


use App\Models\Alert;
use App\Models\Comment;
use App\Models\User;
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
        $response->assertJsonStructure(array_merge(default_pagination_fields(), ['data' => [
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
        ]]));
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
            'body' => $comment->body,
            'title' => $comment->title,
        ]);
        $this->assertDatabaseHas('comments', [
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Models\\Alert',
            'commentable_id' => $alert->uuid,
            'body' => $comment->body,
        ]);
        $response->assertJsonCount(1, 'data');
    }
}
