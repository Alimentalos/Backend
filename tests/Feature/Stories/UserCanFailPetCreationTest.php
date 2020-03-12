<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanFailPetCreationTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanFailPetCreationTest()
    {
        Storage::fake('public');
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
}
