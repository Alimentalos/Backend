<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreatePhotoOfPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreatePhotoOfPet()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();

        $photo->user_uuid = $user->uuid;
        $photo->save();
        $pet->user_uuid = $user->uuid;
        $pet->photo_uuid = $photo->uuid;
        $pet->save();
        $comment = factory(Comment::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/photos', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'title' => $comment->title,
            'body' => $comment->body,
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
            'photoable_type' => 'Alimentalos\\Relationships\\Models\\Pet',
            'photoable_id' => $pet->uuid
        ]);
    }
}
