<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateUserAlertsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateUserAlerts()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $alert = Alert::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/alerts', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'alert_type' => 'Alimentalos\\Relationships\\Models\\User',
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
        Storage::disk('public')->assertExists((json_decode($content))->photo->photo_url);
        $this->assertDatabaseHas('alerts', [
            'uuid' => (json_decode($content))->uuid,
            'title' => $alert->title,
            'body' => $alert->body,
            'type' => $alert->type,
            'status' => $alert->status,
        ]);
    }

}
