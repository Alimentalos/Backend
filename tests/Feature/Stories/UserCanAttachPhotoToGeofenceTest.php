<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Geofence;
use App\Models\Group;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanAttachPhotoToGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachPhotoToGeofence()
    {
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        $photo = Photo::factory()->create();
        change_instance_user($geofence, $user);
        change_instance_user($photo, $user);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/geofences/' . $geofence->uuid . '/photos/' . $photo->uuid . '/attach');
        $response->assertOk();
        $this->assertDatabaseHas('photoables', [
            'photoable_type' => 'App\\Models\\Geofence',
            'photoable_id' => $geofence->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
