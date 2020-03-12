<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPublicDeviceListTest extends TestCase
{
    use RefreshDatabase;

    final public function UserCanViewPublicDeviceListTest()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->is_public = true;
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
            'uuid' => $device->uuid,
            'is_public' => true
        ]);
    }
}
