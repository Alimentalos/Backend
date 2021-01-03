<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewNonPublicDevicesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewNonPublicDevices()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $group = Group::factory()->create();
        $device->is_public = false;
        $device->user_uuid = $user->uuid;
        $device->save();
        $group->devices()->attach($device->uuid);
        $group->users()->attach($user->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices/' . $device->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'user_uuid',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'name',
            'description',
            'is_public',
            'created_at',
            'updated_at',

        ]);
        $response->assertJsonFragment([
            'uuid' => $device->uuid,
        ]);
    }
}
