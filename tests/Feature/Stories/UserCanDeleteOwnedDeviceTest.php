<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDeleteOwnedDeviceTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanDeleteOwnedDeviceTest()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/devices/' . $device->uuid);
        $response->assertOk();

        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
            'message' => 'Resource deleted successfully'
        ]);

    }
}
