<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ChildCanCreateGroupTest extends TestCase
{
    use RefreshDatabase;

    public function testChildCanCreateGroup()
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
            'coordinates' => '10.1,50.5',
            'color' => '#71D91B',
            'background_color' => '#7FF530',
            'border_color' => '#5AAB17',
            'fill_color' => '#1786AB',
            'text_color' => '#136480',
            'user_color' => '#3AA5C9',
            'administrator_color' => '#69BFDB',
            'owner_color' => '#33CCAD',
        ]);
        $content = $response->getContent();
        $response->assertCreated();
        Storage::disk('public')->assertExists((json_decode($content))->photo->photo_url);
    }
}
