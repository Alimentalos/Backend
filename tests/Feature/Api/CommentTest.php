<?php

namespace Tests\Feature\Api;

use App\Comment;
use App\Pet;
use App\Photo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    final public function testStorePhotosCommentsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_uuid = $user->uuid;
        $pet->user_uuid = $user->uuid;
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->save();
        $pet->save();
        $pet->photos()->attach($photo);
        $comment = factory(Comment::class)->make();
        $commentBody = 'Awesome new text';

        $response = $this->actingAs($user, 'api')->json('POST', '/api/photos/' . $photo->uuid . '/comments', [
            'body' => $comment->body,
            'is_public' => true,
        ]);
        $response->assertOk();

        $response->assertJsonStructure([
            'uuid',
            'body',
            'user_uuid',
            'commentable_id',
            'commentable_type',
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);

        $content = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Photo',
            'commentable_id' => $photo->uuid,
            'body' => $comment->body,
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/photos');
        $response->assertOk();

        $response->assertJsonStructure([
            'current_page',
            'data' => [[
                'location' =>[
                    'type',
                    'coordinates',
                ],
                'uuid',
                'user_uuid',
                'ext',
                'photo_url',
                'is_public',
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
                'comment' => [
                    'uuid',
                    'user_uuid',
                    'title',
                    'body',
                    'commentable_type',
                    'commentable_id',
                    'created_at',
                    'updated_at',
                    'love_reactant_id'
                ],
                'pivot' => [
                    'photoable_id',
                    'photo_uuid',
                    'photoable_type'
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
            'photoable_id' => $pet->uuid
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . (json_decode($content))->uuid);
        $response->assertOk();

        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'title',
            'body',
            'commentable_type',
            'commentable_id',
            'created_at',
            'updated_at',
            'love_reactant_id',
            'commentable',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);

        $response = $this->actingAs($user, 'api')->json('PUT', '/api/comments/' . (json_decode($content))->uuid, [
            'body' => $commentBody,
            'is_public' => true,
        ]);
        $response->assertOk();

        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'title',
            'body',
            'commentable_type',
            'commentable_id',
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);

        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/comments/' . (json_decode($content))->uuid);
        $response->assertOk();

        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
           'message' => 'Resource deleted successfully'
        ]);


        $this->assertDeleted('comments', [
            'uuid' => (json_decode($content))->uuid,
        ]);
    }



}
