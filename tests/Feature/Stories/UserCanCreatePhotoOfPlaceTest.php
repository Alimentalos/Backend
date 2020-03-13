<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Pet;
use App\Photo;
use App\Place;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreatePhotoOfPlaceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreatePhotoOfPlace()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $place->user_uuid = $user->uuid;
        $place->photo_uuid = $photo->uuid;
        $place->save();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/places/' . $place->uuid . '/photos', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'is_public' => true,
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'ext',
            'photo_url',
            'is_public',
        ]);
        $content = $response->getContent();
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo_url);

        $this->assertDatabaseHas('photos', [
            'uuid' => (json_decode($content))->uuid,
            'is_public' => true
        ]);
        $this->assertDatabaseHas('photoables', [
            'photo_uuid' => (json_decode($content))->uuid,
            'photoable_type' => 'App\\Place',
            'photoable_id' => $place->uuid
        ]);
    }
}
