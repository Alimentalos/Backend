<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanGetDeviceSpeedReportTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetDeviceSpeedReport()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/reports', [
            'api_token' => $user->api_token,
            'devices' => $device->uuid,
            'accuracy' => 100,
            'start_date' => Carbon::now()->format('d-m-Y 00:00:00'),
            'end_date' => Carbon::now()->format('d-m-Y 23:59:59'),
            'type' => 'speed',
            'min' => 40,
            'max' => 120,
        ]);
        $response->assertOk();
    }
}
