<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateGroupsWithoutPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateGroupsWithoutPhoto()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups', [
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
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'name',
            'created_at',
            'updated_at',
        ]);
    }
}
