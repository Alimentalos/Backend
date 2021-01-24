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

class UserCanAttachPhotoToPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachPhotoToPet()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $photo = Photo::factory()->create();
        change_instance_user($photo, $user);
        change_instance_user($pet, $user);
        $pet->photo_uuid = $photo->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/photos/' . $photo->uuid . '/attach');
        $response->assertOk();
        $this->assertDatabaseHas('photoables', [
            'photoable_type' => 'App\\Models\\Pet',
            'photoable_id' => $pet->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
