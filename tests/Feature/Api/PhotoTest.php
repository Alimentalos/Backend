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
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class PhotoTest extends TestCase
{
    use DatabaseMigrations;

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
        $photo->user_uuid = $user->uuid;
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $user->photo_uuid = $photo->uuid;
        $user->save();
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid);
        $response->assertOk();
        
        
        $response->assertJsonStructure([
            'location' =>[
                'type',
                'coordinates',
            ],
            'uuid',
            'user_uuid',
            'comment_uuid',
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
        ]);

        $response->assertJsonFragment([
            'uuid' => $photo->uuid
        ]);
    }

    public function testUpdatePhotosApi()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/photos/' . $photo->uuid, [
            'title' => 'New title',
            'body' => 'New body added'
        ]);
        $response->assertOk();
        
        $response->assertJsonStructure([
            'location' =>[
                'type',
                'coordinates',
            ],
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'created_at',
            'updated_at',
            'love_reactant_id',
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
        ]);

        $response->assertJsonFragment([
            'uuid' => $photo->uuid
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid);
        $response->assertOk();

        $response->assertJsonStructure([
            'location' =>[
                'type',
                'coordinates',
            ],
            'uuid',
            'user_uuid',
            'comment_uuid',
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
        ]);

        $response->assertJsonFragment([
            'uuid' => $photo->uuid
        ]);
    }

    final public function testUserCanCreateResourcePhotos()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $photo = factory(Photo::class)->create();
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->user_uuid = $user->uuid;
        $user->photo_uuid = $photo->uuid;
        $pet->photo_uuid = $photo->uuid;
        $pet->save();
        $user->save();
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
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
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
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid
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
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
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
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid
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
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
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
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid
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
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
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
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid
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
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/photos/' . $photo->uuid);
        $this->assertDeleted('photos', [
            'uuid' => $photo->uuid,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'user_uuid',
            'uuid',
            'photo_url',
            'ext',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
            'comment_uuid',
            'updated_at',
            'created_at',
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
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $photo->uuid
        ]);
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
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Photo',
            'commentable_id' => $photo->uuid,
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
            'user_uuid' => $user->uuid,
            'body' => $comment->body,
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid . '/comments');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'body',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }
}
