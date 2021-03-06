<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanUpdateOwnedGeofenceWithPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdateOwnedGeofenceWithPhoto()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        $geofence->photo_uuid = Photo::factory()->create()->uuid;
        $geofence->save();
        $geofence->user_uuid = $user->uuid;
        $old_uuid = $geofence->photo_uuid;
        $geofence->save();
        $response = $this->actingAs($user, 'api')->put('/api/geofences/' . $geofence->uuid, [
            'photo' => UploadedFile::fake()->image('photo10.jpg'),
            'name' => 'Nicely!',
            'shape' => [
                ['latitude' => 0, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 7],
                ['latitude' => 7, 'longitude' => 7],
                ['latitude' => 7, 'longitude' => 0],
                ['latitude' => 0, 'longitude' => 0],
            ],
            'is_public' => true,
            'coordinates' => '60.1,25.5'
        ]);
        $response->assertOk();
        $content = json_decode($response->getContent());
        $response->assertJsonFragment([
            'uuid' => $geofence->uuid,
            'user_uuid' => $user->uuid,
            'name' => 'Nicely!',
            'description' => null,
            'photo_uuid' => $content->photo_uuid,
            'shape' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [0,0],
                        [7,0],
                        [7,7],
                        [0,7],
                        [0,0]
                    ]
                ]
            ],
            'is_public' => true,
            'created_at' => $geofence->created_at,
        ]);
        $response->assertOk();
        $this->assertFalse($content->photo->uuid === $old_uuid);
        Storage::disk('public')->assertExists($content->photo->photo_url);
    }
}
