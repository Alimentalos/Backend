<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedDeviceTokenTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedDeviceToken()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->is_public = false;
        $device->user_uuid = $user->uuid;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices/' . $device->uuid . '/token');
        $response->assertOk();
        $response->assertJsonFragment([
            'api_token' => $device->api_token,
            'message' => 'Token retrieved successfully'
        ]);
    }
}
