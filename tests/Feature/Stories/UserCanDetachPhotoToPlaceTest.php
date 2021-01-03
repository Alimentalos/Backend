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

class UserCanDetachPhotoToPlaceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachPhotoToGroup()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $photo = Photo::factory()->create();

        $place->user_uuid = $user->uuid;
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $place->save();
        $place->photos()->attach($photo->uuid);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/places/' . $place->uuid . '/photos/' . $photo->uuid . '/detach');
        $response->assertOk();
        $response->assertExactJson(['message' => 'Resource detached to photo successfully']);
        $this->assertDeleted('photoables', [
            'photoable_type' => 'Alimentalos\\Relationships\\Models\\Place',
            'photoable_id' => $place->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
