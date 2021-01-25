<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\Place;
use App\Models\User;
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
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $photo = Photo::factory()->create();
        change_instance_user($photo, $user);
        change_instance_user($place, $user);
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
        Storage::disk('public')->assertExists((json_decode($content))->photo_url);

        $this->assertDatabaseHas('photos', [
            'uuid' => (json_decode($content))->uuid,
            'is_public' => true
        ]);
        $this->assertDatabaseHas('photoables', [
            'photo_uuid' => (json_decode($content))->uuid,
            'photoable_type' => 'App\\Models\\Place',
            'photoable_id' => $place->uuid
        ]);
    }
}
