<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateGroupsWithPhotoAndWithoutCoordinatesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateGroupsWithPhotoAndWithoutCoordinates()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => $group->name,
            'is_public' => 'true',
            'color' => '#CCCCCC',
            'background_color' => '#CCCCCC',
            'border_color' => '#CCCCCC',
            'fill_color' => '#CCCCCC',
            'text_color' => '#CCCCCC',
            'user_color' => '#CCCCCC',
            'administrator_color' => '#CCCCCC',
            'owner_color' => '#CCCCCC',
        ]);
        $response->assertCreated();
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
            'color',
            'background_color',
            'border_color',
            'fill_color',
            'text_color',
            'user_color',
            'administrator_color',
            'owner_color'
        ]);
        $response->assertJsonFragment([
            'photo_uuid' => (json_decode($content))->photo_uuid,
            'color' => '#CCCCCC',
            'background_color' => '#CCCCCC',
            'border_color' => '#CCCCCC',
            'fill_color' => '#CCCCCC',
            'text_color' => '#CCCCCC',
            'user_color' => '#CCCCCC',
            'administrator_color' => '#CCCCCC',
            'owner_color' => '#CCCCCC',
        ]);
    }
}
