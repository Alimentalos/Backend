<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewNonPublicDevicesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test testUserCanShowNonPublicDevices
     */
    final public function testUserCanShowNonPublicDevices()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
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
