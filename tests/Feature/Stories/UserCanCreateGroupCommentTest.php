<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateGroupCommentTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateGroupComment()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $group->is_public = false;
        $user->groups()->attach($group);
        $group->save();
        $comment = Comment::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups/' . $group->uuid . '/comments', [
            'body' => $comment->body,
            'is_public' => true,
        ]);
        $response->assertOk();
        $content = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Models\\Group',
            'commentable_id' => $group->uuid,
            'body' => $comment->body,
        ]);
    }
}
