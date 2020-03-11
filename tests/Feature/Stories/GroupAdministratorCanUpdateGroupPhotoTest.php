<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Group;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GroupAdministratorCanUpdateGroupPhotoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanUpdateAnOwnedGroupWithPhoto
     */
    final public function testUserCanUpdateAnOwnedGroupWithPhoto()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->photo_uuid = $photo->uuid;
        $group->save();
        $user->groups()->attach($group, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/groups/' . $group->uuid, [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => 'New name',
            'is_public' => true,
            'coordinates' => '10.1,50.5'
        ]);
        $response->assertOk();
        $content = $response->getContent();
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);

        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
            'photo_url',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
            'name' => 'New name',
        ]);

    }
}
