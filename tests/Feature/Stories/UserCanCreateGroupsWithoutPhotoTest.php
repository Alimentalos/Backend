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
            'color' => '#71D91B',
            'background_color' => '#7FF530',
            'border_color' => '#5AAB17',
            'fill_color' => '#1786AB',
            'text_color' => '#136480',
            'user_color' => '#3AA5C9',
            'administrator_color' => '#69BFDB',
            'owner_color' => '#33CCAD',
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
