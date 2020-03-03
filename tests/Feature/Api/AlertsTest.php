<?php

namespace Tests\Feature\Api;

use App\Alert;
use App\Comment;
use App\Device;
use App\Pet;
use App\Photo;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlertsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewAlerts
     */
    public function testUserCanViewAlerts()
    {
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $response = $this->actingAs($user, 'api')->get('/api/alerts');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'location',
                    'user',
                    'photo',
                    'alert'
                ]
            ]
        ]);
    }

    /**
     * @test testUserCanCreateDeviceAlert
     */
    public function testUserCanCreateDeviceAlert()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->make();
        $device = factory(Device::class)->create();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/alerts', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'alert_type' => 'App\\Device',
            'alert_id' => $device->uuid,
            'title' => $alert->title,
            'body' => $alert->body,
            'type' => $alert->type,
            'status' => $alert->status,
            'is_public' => true,
            'coordinates' => '5,5',
        ]);
        $response->assertCreated();

        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);

        $this->assertDatabaseHas('alerts', [
            'uuid' => (json_decode($content))->uuid,
            'title' => $alert->title,
            'body' => $alert->body,
            'type' => $alert->type,
            'status' => $alert->status,
        ]);
    }

    /**
     * @test testUserCanCreatePetAlert
     */
    public function testUserCanCreatePetAlert()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->make();
        $pet = factory(Pet::class)->create();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/alerts', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'alert_type' => 'App\\Pet',
            'alert_id' => $pet->uuid,
            'title' => $alert->title,
            'body' => $alert->body,
            'type' => $alert->type,
            'status' => $alert->status,
            'is_public' => true,
            'coordinates' => '5,5',
        ]);
        $response->assertCreated();

        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);

        $this->assertDatabaseHas('alerts', [
            'uuid' => (json_decode($content))->uuid,
            'title' => $alert->title,
            'body' => $alert->body,
            'type' => $alert->type,
            'status' => $alert->status,
        ]);
    }

    /**
     * @test testUserCanCreateUserAlert
     */
    public function testUserCanCreateUserAlert()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->make();
        $device = factory(Device::class)->create();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/alerts', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'alert_type' => 'App\\User',
            'alert_id' => $user->uuid,
            'title' => $alert->title,
            'body' => $alert->body,
            'type' => $alert->type,
            'status' => $alert->status,
            'is_public' => true,
            'coordinates' => '5,5',
        ]);
        $response->assertCreated();

        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);

        $this->assertDatabaseHas('alerts', [
            'uuid' => (json_decode($content))->uuid,
            'title' => $alert->title,
            'body' => $alert->body,
            'type' => $alert->type,
            'status' => $alert->status,
        ]);
    }

    public function testUserCanViewSpecificAlert()
    {
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $response = $this->actingAs($user, 'api')->get('/api/alerts/' . $alert->uuid);
        $response->assertJsonStructure([
            'uuid',
            'location',
            'user',
            'photo',
            'alert'
        ]);
    }

    public function testUserCanUpdateOwnedAlert()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $alert->user_uuid = $user->uuid;
        $alert->save();
        $modified = factory(Alert::class)->make();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/alerts/' . $alert->uuid, [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'title' => $modified->title,
            'body' => $modified->body,
            'type' => $modified->type,
            'status' => $modified->status,
            'is_public' => true,
            'coordinates' => '5,5',
        ]);
        $response->assertOk();

        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);

        $this->assertDatabaseHas('alerts', [
            'uuid' => (json_decode($content))->uuid,
            'title' => $modified->title,
            'body' => $modified->body,
            'type' => $modified->type,
            'status' => $modified->status,
        ]);
    }

    public function testUserCanDeleteOwnedAlert()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $alert->user_uuid = $user->uuid;
        $alert->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/alerts/' . $alert->uuid);
        $response->assertOk();
        $this->assertDeleted('alerts', [
            'uuid' => $alert->uuid,
        ]);
    }

    final public function testIndexAlertCommentsApi()
    {
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $comment = factory(Comment::class)->make();

        $alert->comments()->create([
            'user_uuid' => $user->uuid,
            'title' => $comment->title,
            'body' => $comment->body,
        ]);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/alerts/' . $alert->uuid . '/comments');
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_uuid',
                    'user',
                    'title',
                    'body',
                    'commentable_id',
                    'commentable_type',
                ]
            ]
        ]);

        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
            'body' => $comment->body,
            'title' => $comment->title,
        ]);
        $this->assertDatabaseHas('comments', [
            'user_uuid' => $user->uuid,
            'commentable_type' => 'App\\Alert',
            'commentable_id' => $alert->uuid,
            'body' => $comment->body,
        ]);
        $response->assertJsonCount(1, 'data');
        $response->assertOk();
    }
}
