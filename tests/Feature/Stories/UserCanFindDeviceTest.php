<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\Group;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindDeviceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanFindDevice()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $device->is_public = true;
        $device->save();
        $group = Group::factory()->create();
        $device->locations()->saveMany(
           Location::factory(10)->create()
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
