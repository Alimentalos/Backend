<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministratorCanViewGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testAdministratorCanViewGroup()
    {
        $user = create_admin();
        $group = Group::factory()->create();
        $photo = Photo::factory()->create();
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $group->photo_uuid = $photo->uuid;
        $group->user_uuid = $user->uuid;
        $user->groups()->attach($group, [
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => false,
        ]);
        $group->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups');
        $response->assertOk();
        $response->assertJsonStructure(
            array_merge(default_pagination_fields(), ['data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
                    'is_public',
                    'photo_url',
                    'created_at',
                    'updated_at',
                ],
            ]])
        );
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
        ]);
    }
}
