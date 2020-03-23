<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserGroupMemberCanViewGroupDevicesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserGroupMemberCanViewGroupDevices()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->photo_uuid = factory(Photo::class)->create()->uuid;
        $userB->save();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $device = factory(Device::class)->create();
        $device->user_uuid = $userB->uuid;
        $device->save();
        $group->save();

        $user->groups()->attach($group, [
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => true
        ]);
        $device->groups()->attach($group, [
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => false
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/devices');
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
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
