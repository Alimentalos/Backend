<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedDeviceInOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanAttachOwnedDeviceInOwnedGroup()
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
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/devices/' . $device->uuid . '/groups/' . $group->uuid . '/attach',
            []
        );
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\Device',
            'groupable_id' => $device->uuid,
            'group_uuid' => $group->uuid,
        ]);
    }
}
