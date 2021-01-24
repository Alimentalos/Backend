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

class UserCanAttachPhotoToGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachPhotoToGroup()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $photo = Photo::factory()->create();
        change_instance_user($group, $user);
        change_instance_user($photo, $user);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups/' . $group->uuid . '/photos/' . $photo->uuid . '/attach');
        $response->assertOk();
        $this->assertDatabaseHas('photoables', [
            'photoable_type' => 'App\\Models\\Group',
            'photoable_id' => $group->uuid,
            'photo_uuid' => $photo->uuid,
        ]);
    }
}
