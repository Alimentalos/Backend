<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedDeviceOfGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanDetachOwnedDeviceOfGroup
     */
    final public function UserCanDetachOwnedDeviceOfGroupTest()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $device->user_uuid = $user->uuid;
        $device->save();
        $device->groups()->attach($group, [
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/devices/' . $device->uuid . '/groups/' . $group->uuid . '/detach',
            []
        );
        $response->assertExactJson(['message' => 'Resource detached to group successfully']);
        $this->assertDeleted('groupables', [
            'groupable_type' => 'App\\Device',
            'groupable_id' => $device->uuid,
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }
}
