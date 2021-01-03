<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanUpdatePetUsingPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdatePetUsingPhoto()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/pets/' . $pet->uuid, [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'name' => 'New name',
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertOk();
        $response->assertJsonFragment([
            "name" => "New name"
        ]);
        $response->assertOk();
        $this->assertDatabaseHas('pets', [
            'uuid' => $pet->uuid,
            'name' => 'New name'
        ]);
        $content = $response->getContent();
        Storage::disk('public')->assertExists((json_decode($content))->photo->photo_url);
    }
}
