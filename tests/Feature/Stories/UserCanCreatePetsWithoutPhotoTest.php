<?php


namespace Tests\Feature\Stories;


use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreatePetsWithoutPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreatePetsWithoutPhoto()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets', [
            'name' => $pet->name,
            'description' => $pet->description,
            'hair_color' => $pet->hair_color,
            'right_eye_color' => $pet->right_eye_color,
            'left_eye_color' => $pet->left_eye_color,
            'size' => $pet->size,
            'born_at' => $pet->born_at->format('Y-m-d H:i:s'),
            'is_public' => true,
        ]);
        $response->assertCreated();
        $this->assertDatabaseHas('pets', [
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
