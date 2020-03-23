<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateGroupCommentTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateGroupComment()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->is_public = false;
        $user->groups()->attach($group);
        $group->save();
        $comment = factory(Comment::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups/' . $group->uuid . '/comments', [
            'body' => $comment->body,
            'is_public' => true,
        ]);
        $response->assertOk();
        $content = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'Alimentalos\\Relationships\\Models\\Group',
            'commentable_id' => $group->uuid,
            'body' => $comment->body,
        ]);
    }
}
