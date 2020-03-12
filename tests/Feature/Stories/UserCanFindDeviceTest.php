<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Group;
use App\Location;
use App\User;
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
