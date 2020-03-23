<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanDetachPhotoToUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachPhotoToUser()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $user->photos()->attach($photo->uuid);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users/' . $user->uuid . '/photos/' . $photo->uuid . '/detach');
        $response->assertOk();
        $response->assertExactJson(['message' => 'Resource detached to photo successfully']);
        $this->assertDeleted('photoables', [
            'photoable_type' => 'Demency\\Relationships\\Models\\User',
            'photoable_id' => $user->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
