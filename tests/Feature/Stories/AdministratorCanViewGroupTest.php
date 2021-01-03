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
        $user = User::factory()->create();
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
        $user->email = 'iantorres@outlook.com';
        $group->save();
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups');
        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data' => [
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
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
        ]);
    }
}
