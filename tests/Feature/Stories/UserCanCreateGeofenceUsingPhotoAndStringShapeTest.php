<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateGeofenceUsingPhotoTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateGeofenceUsingPhoto()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $user->save();
        $response = $this->actingAs($user, 'api')->post('/api/geofences', [
            'photo' => UploadedFile::fake()->image('photo5.jpg'),
            'name' => 'Awesome geofence!',
            'is_public' => true,
            'shape' => '0,0|0,5|5,5|5,0|0.0',
            'coordinates' => '20.1,25.5'
        ]);
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
            'shape' => [
                'type',
                'coordinates'
            ],
            'photo' => [
                'uuid'
            ],
            'is_public',
            'created_at',
            'updated_at',
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }
}
