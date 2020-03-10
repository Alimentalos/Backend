<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DevicesGeofencesApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanCreateGroupComments
     */
    final public function testUserCanCreateGroupComments()
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
            'commentable_type' => 'App\\Group',
            'commentable_id' => $group->uuid,
            'body' => $comment->body,
        ]);
    }
}
