<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanUpdatePetUsingPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanUpdatePetUsingPhotoTest()
    {
        Storage::fake('public');
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

        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }
}
