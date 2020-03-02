<?php

namespace Tests\Feature\Api;

use App\Device;
use App\Group;
use App\Location;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class DevicesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewOwnedPublicDevices
     */
    final public function testUserCanViewOwnedPublicDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->is_public = true;
        $device->user_id = $user->id;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
                    'uuid',
                    'api_token',
                    'name',
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testUserCanViewOwnedPrivateDevices
     */
    final public function testUserCanViewOwnedPrivateDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->is_public = false;
        $device->user_id = $user->id;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
                    'uuid',
                    'api_token',
                    'name',
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testNonVerifiedUserCannotViewOnGroupDevices
     */
    final public function testNonVerifiedUserCannotViewOnGroupDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $group->devices()->attach($device->id);
        $group->users()->attach($user->id);
        $user->email_verified_at = null;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertStatus(403);
    }

    /**
     * @test testUserCanViewOnGroupDevices
     */
    final public function testUserCanViewOnGroupDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $group->devices()->attach($device->id);
        $group->users()->attach($user->id);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
                    'uuid',
                    'api_token',
                    'name',
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }

    /**
     * @test testUserCanViewOnGroupDevice
     */
    final public function testUserCanViewOnGroupDevice()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $group->devices()->attach($device->id);
        $group->users()->attach($user->id);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices/' . $device->uuid);
        $response->assertJsonStructure([
            'id',
            'user_id',
            'uuid',
            'api_token',
            'name',
            'description',
            'created_at',
            'updated_at'
        ]);
        $response->assertOk();
    }

    /**
     * @test testUserCanShowNonPublicDevices
     */
    final public function testUserCanShowNonPublicDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $device->is_public = false;
        $device->save();
        $group->devices()->attach($device->id);
        $group->users()->attach($user->id);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices/' . $device->uuid);
        $response->assertOk();
    }

    /**
     * @test testUserCanStoreDeviceLocations
     */
    final public function testUserCanStoreDeviceLocations()
    {
        $device = factory(Device::class)->create();
        $location = factory(Location::class)->make();
        $response = $this->actingAs($device, 'devices')->json('POST', '/api/device/locations', [
            'api_token' => $device->api_token,
            'device' => '{}',
            'location' => [
                'uuid' => $location->uuid,
                'coords' => [
                    'latitude' => $location->location->getLat(),
                    'longitude' => $location->location->getLng(),
                    'accuracy' => $location->accuracy,
                    'altitude' => $location->altitude,
                    'speed' => $location->speed,
                    'heading' => $location->heading,
                ],
                'odometer' => $location->odometer,
                'event' => $location->event,
                'activity' => [
                    'type' => $location->activity_type,
                    'confidence' => $location->activity_confidence,
                ],
                'battery' => [
                    'level' => $location->battery_level,
                    'is_charging' => $location->battery_is_charging,
                ],
                'is_moving' => $location->is_moving,
                'timestamp' => time(),
            ],
        ]);
        $response->assertCreated();
        $response->assertJsonFragment([
            'latitude' => $location->location->getLat(),
            'longitude' => $location->location->getLng(),
            'accuracy' => $location->accuracy,
            'altitude' => $location->altitude,
            'odometer' => $location->odometer,
            'event' => $location->event,
            'activity' => $location->activity_type,
            'confidence' => $location->activity_confidence,
            'battery' =>  round((float) $location->battery_level * 100),
            'charging' => $location->battery_is_charging,
            'moving' => $location->is_moving,
        ]);
    }

    /**
     * @test testUserCanStoreDevices
     */
    final public function testUserCanStoreDevices()
    {
        $user = factory(User::class)->create();
        $user->free = true;
        $user->save();
        $device = factory(Device::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/devices', [
            'name' => $device->name,
            'is_public' => true,
        ]);
        $response->assertCreated();
    }

    /**
     * @test testUserCanUpdateOwnedDevices
     */
    final public function testUserCanUpdateOwnedDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_id = $user->id;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/devices/' . $device->uuid, [
            'name' => 'New name',
            'is_public' => false,
        ]);
        $response->assertOk();
    }

    /**
     * @test testUserCanDestroyOwnedDevices
     */
    final public function testUserCanDestroyOwnedDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_id = $user->id;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/devices/' . $device->uuid);
        $response->assertOk();
    }

    /**
     * @test testUserCanAttachOwnedDevicesInGroups
     */
    final public function testUserCanAttachOwnedDevicesInGroups()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $group->user_id = $user->id;
        $group->save();
        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $device->user_id = $user->id;
        $device->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/devices/' . $device->uuid . '/groups/' . $group->uuid . '/attach',
            []
        );
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\Device',
            'groupable_id' => $device->id,
            'group_id' => $group->id,
        ]);
    }

    /**
     * @test testUserCanDetachOwnedDevicesInGroups
     */
    final public function testUserCanDetachOwnedDevicesInGroups()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $group->user_id = $user->id;
        $group->save();
        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $device->user_id = $user->id;
        $device->save();
        $device->groups()->attach($group, [
            'status' => Group::ACCEPTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/devices/' . $device->uuid . '/groups/' . $group->uuid . '/detach',
            []
        );
        $response->assertExactJson([]);
        $this->assertDeleted('groupables', [
            'groupable_type' => 'App\\Device',
            'groupable_id' => $device->id,
            'group_id' => $group->id,
        ]);
        $response->assertOk();
    }

    /**
     * @test testUserCanViewTheDeviceGroups
     */
    final public function testUserCanViewTheDeviceGroups()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $group->user_id = $user->id;
        $group->save();
        $group->users()->attach($user, [
            'is_admin' => true,
            'status' => Group::ACCEPTED_STATUS
        ]);
        $device->user_id = $user->id;
        $device->save();
        $device->groups()->attach($group, [
            'status' => Group::ACCEPTED_STATUS
        ]);
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'App\\Device',
            'groupable_id' => $device->id,
            'group_id' => $group->id,
        ]);
        $response = $this->actingAs($user, 'api')->json(
            'GET',
            '/api/devices/' . $device->uuid . '/groups',
            []
        );
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user',
                    'photo',
                    'description',
                    'is_public'
                ]
            ]
        ]);
        // Assert User UUID
        $response->assertJsonFragment([
            'uuid' => $user->uuid,
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
