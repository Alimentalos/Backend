<?php

namespace Tests\Feature\Api;

use App\Comment;
use App\Geofence;
use App\Group;
use App\Pet;
use App\Photo;
use App\Repositories\UniqueNameRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $comment = factory(Comment::class)->make();
        $commentBody = 'Awesome new text';

        $response = $this->actingAs($user, 'api')->json('POST', '/api/photos/' . $photo->uuid . '/comments', [
            'body' => $comment->body,
            'is_public' => true,
        ]);
        $response->assertOk();
        $content = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'id' => (json_decode($content))->id,
            'user_id' => $user->id,
            'commentable_type' => 'App\\Photo',
            'commentable_id' => $photo->id,
            'body' => $comment->body,
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/photos');
        $response->assertOk();

        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . (json_decode($content))->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'commentable_type',
            'commentable_id',
            'uuid',
            'body',
            'user_id',
            'love_reactant_id',
            'created_at',
            'updated_at',
        ]);

        $response = $this->actingAs($user, 'api')->json('PUT', '/api/comments/' . (json_decode($content))->uuid, [
            'body' => $commentBody,
            'is_public' => true,
        ]);
        $response->assertOk();
        $response->assertJsonFragment([
            'user_id' => $user->id,
            'body' => $commentBody,
        ]);

        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/comments/' . (json_decode($content))->uuid);
        $response->assertOk();
        $this->assertDeleted('comments', [
            'id' => (json_decode($content))->id,
        ]);
    }

    /**
     * @test testIndexPhotosCommentsApi
     */
    final public function testIndexPhotosCommentsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->pets()->attach($pet);
        $photo->save();
        $comment = factory(Comment::class)->make();
        $photo->comments()->create([
            'user_id' => $user->id,
            'body' => $comment->body,
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid . '/comments');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
                    'body',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'user_id' => $user->id,
            'body' => $comment->body,
        ]);
    }

    /**
     * @test testCommentsOfComments
     */
    final public function testCommentsOfComments()
    {
        $sampleCommentBody = 'Sample comment';
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();
        $comment->user_id = $user->id;
        $comment->save();
        $comment->comments()->create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'body' => $sampleCommentBody,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . $comment->uuid . '/comments');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'uuid',
                    'user_id',
                    'body',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'body' => $sampleCommentBody,
            'user_id' => $user->id,
        ]);
    }

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
            'id',
            'commentable_type',
            'commentable_id',
            'uuid',
            'body',
            'user_id',
            'love_reactant_id',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'user_id' => $user->id,
            'body' => $parentComment->body,
        ]);
        $parentContent = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'id' => (json_decode($parentContent))->id,
            'user_id' => $user->id,
            'commentable_type' => 'App\\Photo',
            'commentable_id' => $photo->id,
            'body' => $parentComment->body,
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/comments/' . (json_decode($parentContent))->uuid . '/comments', [
            'body' => $childComment->body,
        ]);
        $response->assertOk();
        $childContent = $response->getContent();
        $this->assertDatabaseHas('comments', [
            'id' => (json_decode($childContent))->id,
            'user_id' => $user->id,
            'commentable_type' => 'App\\Comment',
            'commentable_id' => (json_decode($parentContent))->id,
            'body' => $childComment->body,
        ]);
        $response->assertJsonStructure([
            'id',
            'commentable_type',
            'commentable_id',
            'uuid',
            'body',
            'user_id',
            'love_reactant_id',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'body' => $childComment->body,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . (json_decode($parentContent))->uuid . '/comments');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'uuid',
                    'user_id',
                    'body',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'body' => $childComment->body,
            'user_id' => $user->id,
        ]);
    }

}
