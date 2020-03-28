<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanDetachPhotoToGeofenceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachPhotoToGeofence()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $photo = factory(Photo::class)->create();

        $geofence->user_uuid = $user->uuid;
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $geofence->save();
        $geofence->photos()->attach($photo->uuid);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/geofences/' . $geofence->uuid . '/photos/' . $photo->uuid . '/detach');
        $response->assertOk();
        $response->assertExactJson(['message' => 'Resource detached to photo successfully']);
        $this->assertDeleted('photoables', [
            'photoable_type' => 'Alimentalos\\Relationships\\Models\\Geofence',
            'photoable_id' => $geofence->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
