<?php


namespace Tests\Feature\Stories;


use App\Alert;
use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreatePetAlertsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanCreatePetAlerts
     */
    public function testUserCanCreatePetAlerts()
    {
        Storage::fake('public');
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
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);

        $this->assertDatabaseHas('alerts', [
            'uuid' => (json_decode($content))->uuid,
            'title' => $alert->title,
            'body' => $alert->body,
            'type' => $alert->type,
            'status' => $alert->status,
        ]);
    }
}