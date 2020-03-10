<?php

namespace Tests\Feature\Api;

use App\Alert;
use App\Comment;
use App\Device;
use App\Pet;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AlertsTest extends TestCase
{
    use DatabaseMigrations;

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

        $response->assertJsonStructure([
            'user_uuid',
            'photo_uuid',
            'alert_id',
            'alert_type',
            'photo_url',
            'location' => [
                'type',
                'coordinates'
            ],
            'title',
            'body',
            'type',
            'status',
            'uuid',
            'updated_at',
            'created_at',
            'photo' => [
                'location' => [
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
                'love_reactant_id'
            ],
            'user' => [
                'uuid',
                'user_uuid',
                'photo_uuid',
                'name',
                'email',
                'email_verified_at',
                'free',
                'photo_url',
                'location' => [
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
            'user_uuid' => $user->uuid,
        ]);

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

        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
           'message' => 'Resource deleted successfully'
        ]);
    
        
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
            'current_page',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'title',
                    'body',
                    'commentable_type',
                    'commentable_id',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                    'user' => [
                        'uuid',
                        'user_uuid',
                        'photo_uuid',
                        'name',
                        'email',
                        'email_verified_at',
                        'free',
                        'photo_url',
                        'location' => [
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
                    ] ,
                ],
            ],
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
        ]);

        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
        ]);

        $response->assertJsonFragment([
            'uuid' => $user->uuid,
        ]);

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

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'title',
                    'body',
                    'commentable_type',
                    'commentable_id',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                    'user' => [
                        'uuid',
                        'user_uuid',
                        'photo_uuid',
                        'name',
                        'email',
                        'email_verified_at',
                        'free',
                        'photo_url',
                        'location' => [
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
                    ] ,
                ],
            ],
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
        ]);

        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
        ]);

        $response->assertJsonFragment([
            'uuid' => $user->uuid,
        ]);

    }
}
