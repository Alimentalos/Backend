<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanUpdateOwnedDeviceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdateOwnedDevice()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/devices/' . $device->uuid, [
            'name' => 'New name',
            'is_public' => false,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'uuid',
            'name',
            'description',
            'created_at',
            'updated_at'
        ]);
        $response->assertJsonFragment([
            'uuid' => $device->uuid,
        ]);
    }
}
