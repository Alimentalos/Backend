<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateChildUsersTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateChildUsers()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $userB = factory(User::class)->make();
        $latitude = rand(1,5);
        $longitude = rand(4,10);
        $coordinates = $latitude . ',' . $longitude;
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => $userB->name,
            'email' => $userB->email,
            'password' => $userB->password,
            'password_confirmation' => $userB->password,
            'is_public' => true,
            'coordinates' => $coordinates,
            'color' => '#CCCCCC',
            'border_color' => '#CCCCCC',
            'background_color' => '#CCCCCC',
            'text_color' => '#CCCCCC',
            'marker_color' => '#CCCCCC',
        ]);
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
        $response->assertJsonFragment([
            'coordinates' => [
                $longitude,
                $latitude,
            ],
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }
}
