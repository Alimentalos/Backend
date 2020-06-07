<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateGeofenceWithoutMarkerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateGeofenceWithoutMarker()
    {
        $user = factory(User::class)->create();
        $user->save();
        $response = $this->actingAs($user, 'api')->post('/api/geofences', [
            'name' => 'Awesome geofence!',
            'is_public' => true,
            'shape' => '0,0|0,5|5,5|5,0|0,0',
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
            'name',
            'shape' => [
                'type',
                'coordinates'
            ],
            'is_public',
            'created_at',
            'updated_at',
        ]);
    }
}