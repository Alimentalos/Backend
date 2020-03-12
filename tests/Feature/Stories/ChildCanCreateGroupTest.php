<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ChildCanCreateGroupTest extends TestCase
{
    use RefreshDatabase;

    public function ChildCanCreateGroupTest()
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
}
