<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreatePetsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testUserCanCreatePets
     */
    final public function testUserCanCreatePets()
    {
        Storage::fake('public');
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
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
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
}
