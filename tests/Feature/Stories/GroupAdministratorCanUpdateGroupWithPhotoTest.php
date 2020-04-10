<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GroupAdministratorCanUpdateGroupWithPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testGroupAdministratorCanUpdateGroupWithPhoto()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();

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
        Storage::disk('public')->assertExists((json_decode($content))->photo->photo_url);
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
