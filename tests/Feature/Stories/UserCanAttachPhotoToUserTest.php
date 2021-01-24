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

class UserCanAttachPhotoToUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachPhotoToUser()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        change_instance_user($photo, $user);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users/' . $user->uuid . '/photos/' . $photo->uuid . '/attach');
        $response->assertOk();
        $this->assertDatabaseHas('photoables', [
            'photoable_type' => 'App\\Models\\User',
            'photoable_id' => $user->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
