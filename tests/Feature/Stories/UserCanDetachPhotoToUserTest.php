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

class UserCanDetachPhotoToUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachPhotoToUser()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();

        $photo->user_uuid = $user->uuid;
        $photo->save();
        $user->photos()->attach($photo->uuid);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users/' . $user->uuid . '/photos/' . $photo->uuid . '/detach');
        $response->assertOk();
        $response->assertExactJson(['message' => 'Resource detached to photo successfully']);
        $this->assertDeleted('photoables', [
            'photoable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'photoable_id' => $user->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
