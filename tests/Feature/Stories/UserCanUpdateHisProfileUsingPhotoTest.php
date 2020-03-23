<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanUpdateHisProfileUsingPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdateHisProfileUsingPhoto()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/users/' . $user->uuid, [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => 'New name',
            'is_public' => true,
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'location',
            'photo_uuid',
            'name',
            'email',
            'email_verified_at',
            'free',
            'photo_url',
        ]);
        $content = $response->getContent();
        $this->assertTrue((json_decode($content))->photo_url !== $user->photo_url);
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }
}
