<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Models\User;
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
            'photoable_type' => 'Alimentalos\\Relationships\\Models\\Place',
            'photoable_id' => $place->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
