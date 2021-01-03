<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewLocationsOfDeviceTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewLocationsOfDevice()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
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
