<?php

namespace Tests\Feature\Api;

use App\Comment;
use App\Geofence;
use App\Group;
use App\Pet;
use App\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class PhotoTest extends TestCase
{
    public function testIndexPhotosApi()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/');
        $response->assertOk();
    }

    public function testShowPhotosApi()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid);
        $response->assertOk();
    }

    public function testUpdatePhotosApi()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_id = $user->id;
        $photo->save();
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/photos/' . $photo->uuid, [
            'title' => 'New title'
        ]);
        $response->assertOk();
    }

    final public function testUserCanCreateResourcePhotos()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_id = $user->id;
        $pet->save();
        $group = factory(Group::class)->create();
        $group->user_id = $user->id;
        $group->save();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_id = $user->id;
        $geofence->save();
        $photo = factory(Photo::class)->create();
        $photo->user_id = $user->id;
        $photo->save();

        // User

        $response = $this->actingAs($user, 'api')->json('POST', '/api/users/' . $user->uuid . '/photos/', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'title' => 'New title',
            'is_public' => true,
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'user_id',
            'uuid',
            'photo_url',
            'ext',
            'is_public',
            'comment' => [
                'uuid',
                'title',
                'body',
            ],
            'user' => [
                'name',
                'email'
            ]
        ]);
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);


        // Pet

        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/photos/', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'title' => 'New title',
            'is_public' => true,
            'coordinates' => '60.1,25.5'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'user_id',
            'uuid',
            'photo_url',
            'ext',
            'is_public',
            'comment' => [
                'uuid',
                'title',
                'body',
            ],
            'user' => [
                'name',
                'email'
            ]
        ]);

        Storage::disk('gcs')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);

        // Geofence

        $response = $this->actingAs($user, 'api')->json('POST', '/api/geofences/' . $geofence->uuid . '/photos/', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'title' => 'New title',
            'is_public' => true,
            'coordinates' => '60.1,25.5'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'user_id',
            'uuid',
            'photo_url',
            'ext',
            'is_public',
            'comment' => [
                'uuid',
                'title',
                'body',
            ],
            'user' => [
                'name',
                'email'
            ]
        ]);
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);

        // Group

        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups/' . $group->uuid . '/photos/', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'title' => 'New title',
            'is_public' => true,
            'coordinates' => '60.1,25.5'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'user_id',
            'uuid',
            'photo_url',
            'ext',
            'is_public',
            'comment' => [
                'uuid',
                'title',
                'body',
            ],
            'user' => [
                'name',
                'email'
            ]
        ]);
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);
    }

    /**
     * @test testUserCanDestroyOwnedPhoto
     */
    public function testUserCanDestroyOwnedPhoto()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_id = $user->id;
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/photos/' . $photo->uuid);
        $this->assertDeleted('photos', [
            'id' => $photo->id,
        ]);
        $response->assertOk();
    }

    /**
     * @test testUserCanCreatePhotoComments
     */
    final public function testUserCanCreatePhotoComments()
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
     * @test testUserCanViewPhotoComments
     */
    final public function testUserCanViewPhotoComments()
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
}
