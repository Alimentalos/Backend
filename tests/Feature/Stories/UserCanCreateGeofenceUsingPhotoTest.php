<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
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
            'shape' => [
                ['latitude' => 0, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 5],
                ['latitude' => 5, 'longitude' => 5],
                ['latitude' => 5, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 0],
            ],
            'coordinates' => '20.1,25.5',
            'color' => '#CCCCCC',
            'border_color' => '#CCCCCC',
            'background_color' => '#CCCCCC',
            'text_color' => '#CCCCCC',
            'fill_color' => '#CCCCCC',
            'tag_color' => '#CCCCCC',
            'marker_color' => '#CCCCCC',
            'fill_opacity' => '1',
        ]);
        $response->assertCreated();
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
        $content = $response->getContent();
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }
}
