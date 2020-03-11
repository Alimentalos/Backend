<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateCommentsOfCommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanCreateCommentComments
     */
    final public function testUserCanCreateCommentComments()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $parentComment = factory(Comment::class)->make();
        $childComment = factory(Comment::class)->make();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/photos/' . $photo->uuid . '/comments', [
            'body' => $parentComment->body,
        ]);
        $response->assertOk();

        $response->assertJsonStructure([
            'uuid',
            'body',
            'user_uuid',
            'commentable_id',
            'commentable_type',
            'updated_at',
            'created_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);

        $parentContent = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($parentContent))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Photo',
            'commentable_id' => $photo->uuid,
            'body' => $parentComment->body,
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/comments/' . (json_decode($parentContent))->uuid . '/comments', [
            'body' => $childComment->body,
        ]);
        $response->assertOk();

        $response->assertJsonStructure([
            'uuid',
            'body',
            'user_uuid',
            'commentable_id',
            'commentable_type',
            'updated_at',
            'created_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
            'body' => $childComment->body,
        ]);

        $childContent = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($childContent))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Comment',
            'commentable_id' => (json_decode($parentContent))->uuid,
            'body' => $childComment->body,
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . (json_decode($parentContent))->uuid . '/comments');
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
                'user' =>[
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'email',
                    'email_verified_at',
                    'free',
                    'photo_url',
                    'location' =>[
                        'type',
                        'coordinates',
                    ],
                    'is_public',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                    'love_reacter_id',
                    'is_admin',
                    'is_child',
                ],
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
            'body' => $childComment->body,
        ]);
    }
}
