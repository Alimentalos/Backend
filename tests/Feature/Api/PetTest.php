<?php

namespace Tests\Feature\Api;

use App\Comment;
use App\Device;
use App\Group;
use App\Pet;
use App\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class PetTest extends TestCase
{
    use DatabaseMigrations;

    final public function testStorePetsCommentsApi()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $comment = factory(Comment::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/comments', [
            'body' => $comment->body
        ]);
        $response->assertOk();

        $content = $response->getContent();

        $this->assertDatabaseHas('comments', [
            'uuid' => (json_decode($content))->uuid,
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Pet',
            'commentable_id' => $pet->uuid,
            'body' => $comment->body
        ]);
    }

    final public function testIndexPetsCommentsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $comment = factory(Comment::class)->make();

        $pet->comments()->create([
            'user_uuid' => $user->uuid,
            'title' => $comment->title,
            'body' => $comment->body,
        ]);

        $photo->pets()->attach($pet);
        $photo->save();

        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/comments');

        $response->assertOk();


        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'user',
                    'title',
                    'body',
                    'commentable_id',
                    'commentable_type',
                ]
            ]
        ]);
        // Forma de comprobar
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
            'body' => $comment->body,
            'title' => $comment->title,
        ]);
        $this->assertDatabaseHas('comments', [
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Pet',
            'commentable_id' => $pet->uuid,
            'body' => $comment->body,
        ]);
        $response->assertJsonCount(1, 'data');
        $response->assertOk();
    }

    final public function testIndexPetsPhotosApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->pets()->attach($pet);
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }

    final public function testIndexPetsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets');
        $response->assertOk();
        $response->assertJsonStructure([
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
                    'hair_color',
                    'left_eye_color',
                    'size',
                    'born_at',
                    'api_token',
                    'is_public',
                    'created_at',
                    'updated_at',
                    'user',
                    'photo',
                ]
            ]
        ]);
    }

    final public function testShowPetsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid);
        $response->assertOk();

        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
            'description',
            'hair_color',
            'left_eye_color',
            'size',
            'born_at',
            'api_token',
            'is_public',
            'created_at',
            'updated_at',
            'user',
            'photo',
        ]);
    }

    final public function testStorePetsApi()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'name' => $pet->name,
            'description' => $pet->description,
            'hair_color' => $pet->hair_color,
            'right_eye_color' => $pet->right_eye_color,
            'left_eye_color' => $pet->left_eye_color,
            'size' => $pet->size,
            'born_at' => $pet->born_at->format('Y-m-d H:i:s'),
            'is_public' => true,
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertCreated();

        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . (json_decode($content))->uuid . '/photos');
        $response->assertOk();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/pets');
        $response->assertOk();

        $this->assertDatabaseHas('pets', [
            'uuid' => (json_decode($content))->uuid,
            'name' => $pet->name,
            'description' => $pet->description,
            'hair_color' => $pet->hair_color,
            'right_eye_color' => $pet->right_eye_color,
            'left_eye_color' => $pet->left_eye_color,
            'size' => $pet->size,
            'is_public' => true
        ]);
    }

    final public function testFailedStoredPetsApi()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'description' => $pet->description,
            'hair_color' => $pet->hair_color,
            'right_eye_color' => $pet->right_eye_color,
            'left_eye_color' => $pet->left_eye_color,
            'size' => $pet->size,
            'born_at' => $pet->born_at,
            'is_public' => true
        ]);
        $response->assertStatus(422);
    }

    final public function testUpdateNamePetsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/pets/' . $pet->uuid, [
            'name' => 'New name',
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertJsonFragment([
            "name" => "New name"
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('pets', [
            'uuid' => $pet->uuid,
            'name' => 'New name'
        ]);
    }

    final public function testUpdateNameWithPhotoPetsApi()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/pets/' . $pet->uuid, [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'name' => 'New name',
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertJsonFragment([
            "name" => "New name"
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('pets', [
            'uuid' => $pet->uuid,
            'name' => 'New name'
        ]);
        $content = $response->getContent();

        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }

    final public function testUpdateDescriptionPetsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/pets/' . $pet->uuid, [
            'name' => 'New name',
            'description' => 'New description',
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertJsonFragment([
            'name' => 'New name',
            'description' => 'New description',
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('pets', [
            'uuid' => $pet->uuid,
            'name' => 'New name',
            'description' => 'New description',
        ]);
    }

    final public function testDestroyPetsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/pets/' . $pet->uuid);
        $response->assertOk();

        $this->assertDeleted('pets', [
            'uuid' => $pet->uuid,
        ]);
    }
}
