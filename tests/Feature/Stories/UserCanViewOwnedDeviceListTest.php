<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedDeviceListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewOwnedDeviceList
     */
    final public function testUserCanViewOwnedDeviceList()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->is_public = false;
        $device->user_uuid = $user->uuid;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertOk();

        $response->assertJsonStructure([
            'current_page',
            'data' => [[
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
            ]],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);
    }
}
