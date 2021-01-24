<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Group;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanDetachPhotoToGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachPhotoToGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $photo = Photo::factory()->create();

        $group->user_uuid = $user->uuid;
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $group->save();
        $group->photos()->attach($photo->uuid);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups/' . $group->uuid . '/photos/' . $photo->uuid . '/detach');
        $response->assertOk();
        $response->assertExactJson(['message' => 'Resource detached to photo successfully']);
        $this->assertDeleted('photoables', [
            'photoable_type' => 'App\\Models\\Group',
            'photoable_id' => $group->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
