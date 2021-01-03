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
        $user = User::factory()->create();
        $user->save();
        $response = $this->actingAs($user, 'api')->post('/api/geofences', [
            'name' => 'Awesome geofence!',
            'is_public' => true,
            'shape' => '0,0|0,5|5,5|5,0|0,0',
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
