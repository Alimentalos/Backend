<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewLocationsOfDeviceTest extends TestCase
{
    use RefreshDatabase;

    public function UserCanViewLocationsOfDeviceTest()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/locations', [
            'api_token' => $user->api_token,
            'type' => 'devices',
            'identifiers' => $device->uuid,
            'accuracy' => 100,
            'start_date' => Carbon::now()->format('d-m-Y 00:00:00'),
            'end_date' => Carbon::now()->format('d-m-Y 23:59:59')
        ]);
        $response->assertOk();
    }
}
