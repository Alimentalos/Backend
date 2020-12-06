<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateGeofenceWithPhotoTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateGeofenceWithPhoto()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $user->save();
        $response = $this->actingAs($user, 'api')->post('/api/geofences', [
            'photo' => UploadedFile::fake()->image('photo5.jpg'),
            'marker' => UploadedFile::fake()->image('marker.jpg'),
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
            'color' => '#7FF530',
            'border_color' => '#71D91B',
            'background_color' => '#5AAB17',
            'text_color' => '#1786AB',
            'fill_color' => '#136480',
            'tag_color' => '#3AA5C9',
            'marker_color' => '#69BFDB',
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
        Storage::disk('public')->assertExists((json_decode($content))->photo->photo_url);
    }
}
