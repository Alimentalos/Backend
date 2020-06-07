<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateGroupsWithoutColorsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateGroupsWithoutColors()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups', [
            'name' => $group->name,
            'is_public' => 'true',
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
