<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateChildUsersWithPhotoAndWithoutCoordinatesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateChildUsersWithPhotoAndWithoutCoordinates()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $userB = User::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'marker' => UploadedFile::fake()->image('dev.jpg'),
            'name' => $userB->name,
            'email' => $userB->email,
            'password' => $userB->password,
            'password_confirmation' => $userB->password,
            'is_public' => true,
            'color' => '#71D91B',
            'border_color' => '#7FF530',
            'background_color' => '#5AAB17',
            'text_color' => '#1786AB',
            'marker_color' => '#136480',
        ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'user_uuid',
            'photo_uuid',
            'photo_url',
            'email',
            'name',
            'is_public',
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child',
        ]);
        $response->assertJsonFragment([
            'name' => $userB->name,
            'email' => $userB->email,
            'is_public' => true,
        ]);
        $content = $response->getContent();
        Storage::disk('public')->assertExists((json_decode($content))->photo->photo_url);
    }
}
