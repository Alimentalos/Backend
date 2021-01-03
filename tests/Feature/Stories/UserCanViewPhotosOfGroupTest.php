<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosOfGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewGroupPhotos()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $photo = Photo::factory()->create();
        $photo->groups()->attach($group->uuid);
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/photos');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }
}
