<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\Location;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindDeviceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanFindDevice()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->is_public = true;
        $device->save();
        $group = factory(Group::class)->create();
        $device->locations()->saveMany(
            factory(Location::class, 10)->create()
        );
        $group->devices()->attach($device->uuid);
        $group->users()->attach($user->uuid);
        $responseDevices = $this->actingAs($user, 'api')->json('GET', '/api/find', [
            'api_token' => $user->api_token,
            'type' => 'devices',
            'identifiers' => [$device->uuid],
            'accuracy' => 100,
        ]);
        $responseDevices->assertOk();
        $responseDevices->assertJsonStructure([
            [
                'trackable_id',
                'trackable_type',
                'uuid',
                'accuracy',
                'altitude',
                'longitude',
                'latitude',
                'speed',
                'generated_at',
                'created_at'
            ]
        ]);
    }
}
