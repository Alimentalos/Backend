<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanDetachPhotoToPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachPhotoToPet()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $photo = Photo::factory()->create();

        $photo->user_uuid = $user->uuid;
        $photo->save();
        $pet->user_uuid = $user->uuid;
        $pet->photo_uuid = $photo->uuid;
        $pet->save();
        $pet->photos()->attach($photo->uuid);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/photos/' . $photo->uuid . '/detach');
        $response->assertOk();
        $response->assertExactJson(['message' => 'Resource detached to photo successfully']);
        $this->assertDeleted('photoables', [
            'photoable_type' => 'App\\Models\\Pet',
            'photoable_id' => $pet->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
