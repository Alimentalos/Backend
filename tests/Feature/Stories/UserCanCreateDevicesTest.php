<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateDevicesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanCreateDevices
     */
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
    }
}