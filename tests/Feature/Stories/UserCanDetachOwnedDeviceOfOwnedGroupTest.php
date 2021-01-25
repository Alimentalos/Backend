<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDetachOwnedDeviceOfOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDetachOwnedDeviceOfOwnedGroup()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $group = Group::factory()->create();
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
            'groupable_type' => 'App\\Models\\Device',
            'groupable_id' => $device->uuid,
            'group_uuid' => $group->uuid,
        ]);
        $response->assertOk();
    }
}
