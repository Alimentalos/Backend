<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewGroupOfDeviceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewTheDeviceGroups
     */
    final public function testUserCanViewTheDeviceGroups()
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
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\Device',
            'groupable_id' => $device->uuid,
            'group_uuid' => $group->uuid,
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/devices/' . $device->uuid . '/groups',
            []
        );
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user',
                    'photo',
                    'description',
                    'is_public'
                ]
            ]
        ]);
        // Assert User UUID
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid,
        ]);
        // Assert Group UUID
        $response->assertJsonFragment([
            'uuid' => $group->uuid,
        ]);
        // Assert Photo UUID
        $response->assertJsonFragment([
            'uuid' => json_decode($response->getContent())->data[0]->photo->uuid,
        ]);
        $response->assertOk();
    }
}
