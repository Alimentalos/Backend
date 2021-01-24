<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Group;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanAttachPhotoToPlaceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachPhotoToPlace()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $photo = Photo::factory()->create();
        change_instance_user($place, $user);
        change_instance_user($photo, $user);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/places/' . $place->uuid . '/photos/' . $photo->uuid . '/attach');
        $response->assertOk();
        $this->assertDatabaseHas('photoables', [
            'photoable_type' => 'App\\Models\\Place',
            'photoable_id' => $place->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
