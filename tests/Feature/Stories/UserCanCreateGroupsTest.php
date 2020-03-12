<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateGroupsTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanCreateGroupsTest()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => $group->name,
            'is_public' => 'true',
            'coordinates' => '10.1,50.5'
        ]);
        $response->assertCreated();
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
            'photo_uuid' => (json_decode($content))->photo_uuid,
        ]);
    }
}
