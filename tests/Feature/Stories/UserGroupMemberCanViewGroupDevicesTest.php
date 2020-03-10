<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserGroupMemberCanViewGroupDevicesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test testGroupMemberUserCanViewRelatedGroupDevices
     */
    final public function testGroupMemberUserCanViewRelatedGroupDevices()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $group = factory(Group::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $userB->uuid;
        $device->save();

        $user->groups()->attach($group, ['is_admin' => true]);
        $device->groups()->attach($group);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/devices');
        $response->assertJsonCount(1, 'data');
        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'location' => [
                        'type',
                        'coordinates',
                    ],
                    'name',
                    'description',
                    'is_public',
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
            'uuid' => $device->uuid,
        ]);
    }
}
