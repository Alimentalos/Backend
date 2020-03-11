<?php

namespace Tests\Feature\Api;

use App\Comment;
use App\Device;
use App\Geofence;
use App\Group;
use App\Pet;
use App\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testChildUserCanStoreGroup
     */
    public function testChildUserCanStoreGroup()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $user->uuid;
        $userB->save();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($userB, 'api')->json('POST', '/api/groups', [
            'photo' => UploadedFile::fake()->image('photo2.jpg'),
            'name' => $group->name,
            'is_public' => 'false',
            'coordinates' => '10.1,50.5'
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        Storage::disk('public')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }

    /**
     * @test testUserCanDestroyOwnedGroup
     */
    public function testUserCanDestroyOwnedGroup()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $user->groups()->attach($group, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/groups/' . $group->uuid);
        $this->assertDeleted('groups', [
            'uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }
}
