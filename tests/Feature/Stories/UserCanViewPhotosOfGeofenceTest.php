<?php


namespace Tests\Feature\Stories;


use App\Models\Geofence;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosOfGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPhotosOfGeofence()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        $photo = Photo::factory()->create();
        $photo->geofences()->attach($geofence->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/geofences/' . $geofence->uuid . '/photos');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }
}
