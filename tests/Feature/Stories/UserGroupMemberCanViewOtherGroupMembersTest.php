<?php


namespace Tests\Feature\Stories;


use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserGroupMemberCanViewOtherGroupMembersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test testGroupMemberUserCanViewRelatedGroupUsers
     */
    final public function testGroupMemberUserCanViewRelatedGroupUsers()
    {
        $user = factory(User::class)->create();
        $member = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $user->groups()->attach($group, ['is_admin' => true]);
        $member->groups()->attach($group, ['is_admin' => false]);
        $response = $this->actingAs($member, 'api')->json('GET', '/api/groups/' . $group->uuid . '/users');
        $response->assertJsonCount(2, 'data');

        $response -> assertJsonStructure([
            'current_page',
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
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'email',
                    'email_verified_at',
                    'free',
                    'photo_url',
                    'location'=>[
                        'type',
                        'coordinates'
                    ],
                    'is_public',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                    'love_reacter_id',
                    'is_admin',
                    'is_child',
                    'user',
                    'photo',
                ]
            ],
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $response->assertOk();
    }
}
