<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnlyGroupAdministratorCanUpdateGroupTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test testUserGroupAdministratorCanUpdateGroup
     */
    final public function testUserGroupAdministratorCanUpdateGroup()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/groups/' . $group->uuid, [
            'name' => 'New name'
        ]);
        $this->assertDatabaseHas('actions', [
            'resource' => 'App\\Http\\Controllers\\Api\\Resource\\UpdateController',
            'referenced_uuid' => $group->uuid,
        ]);

        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
            'photo_url',
            'created_at',
            'updated_at',
            'user' => [
                'uuid',
                'user_uuid',
                'photo_uuid',
                'name',
                'email',
                'email_verified_at',
                'free',
                'photo_url',
                'location' => [
                    'type',
                    'coordinates',
                ],
                'is_public',
                'created_at',
                'updated_at',
                'love_reactant_id',
                'love_reacter_id',
                'is_admin',
                'is_child',
            ] ,
            'photo' => [
                'location' => [
                    'type',
                    'coordinates',
                ],
                'uuid',
                'user_uuid',
                'comment_uuid',
                'ext',
                'photo_url',
                'is_public',
                'created_at',
                'updated_at',
                'love_reactant_id',
            ]
        ]);
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
            'name' => 'New name',
        ]);
        $response->assertOk();
    }
}
