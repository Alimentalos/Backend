<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateDevicesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateDevices()
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
        $response->assertJsonStructure([
            'name',
            'description',
            'user_uuid',
            'is_public',
            'uuid',
            'updated_at',
            'created_at',
        ]);
        $response->assertJsonFragment([
            'name' => $device->name,
            'is_public' => true,
        ]);
    }
}
