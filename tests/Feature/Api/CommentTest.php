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
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/comments/' . (json_decode($content))->uuid, [
            'body' => 'Awesome new text',
            'is_public' => true,
        ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/comments/' . (json_decode($content))->uuid);
        $response->assertOk();
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
        $response->assertOk();
    }

    /**
     * @test testCommentsOfComments
     */
    final public function testCommentsOfComments()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();
        $comment->user_id = $user->id;
        $comment->save();
        $comment->comments()->create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'body' => 'Sample comment',
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/comments/' . $comment->uuid . '/comments');
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
        $response->assertOk();
    }
}
