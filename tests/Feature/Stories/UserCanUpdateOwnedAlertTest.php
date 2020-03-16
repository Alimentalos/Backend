<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Alert;
use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanUpdateOwnedAlertTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanUpdateOwnedAlert()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $comment = factory(Comment::class)->create();
        $photo = factory(Photo::class)->create();
        $comment->user_uuid = $user->uuid;
        $photo->user_uuid = $user->uuid;
        $comment->save();
        $photo->save();
        $alert->photo_uuid = $photo->uuid;
        $alert->user_uuid = $user->uuid;
        $alert->save();
        $modified = factory(Alert::class)->make();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/alerts/' . $alert->uuid, [
            'photo' => UploadedFile::fake()->image('photo.png'),
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
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
        ]);
        $content = json_decode($response->getContent());
        Storage::disk('public')->assertExists('photos/' . $content->photo->photo_url);
        $this->assertDatabaseHas('alerts', [
            'uuid' => $content->uuid,
            'title' => $modified->title,
            'body' => $modified->body,
            'type' => $modified->type,
            'status' => $modified->status,
        ]);
    }
}
