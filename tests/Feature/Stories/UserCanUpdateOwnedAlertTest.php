<?php


namespace Tests\Feature\Stories;


use App\Alert;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanUpdateOwnedAlertTest extends TestCase
{
    use RefreshDatabase;

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
}
