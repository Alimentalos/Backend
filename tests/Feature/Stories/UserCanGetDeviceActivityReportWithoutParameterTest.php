<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Location;
use Alimentalos\Relationships\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanGetDeviceActivityReportWithoutParameterTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetDeviceActivityReportWithoutParameter()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $group = Group::factory()->create();
        $device->save();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location1 = $device->locations()->create(
            Location::factory()->make()->toArray()
        );
        $group = Group::factory()->create();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location1->update([
            'generated_at' => Carbon::now()->format('Y-m-d 11:00:00'),
            'is_moving' => 1,
            'device_uuid' => $device->uuid,
        ]);
        $location2 = $device->locations()->create(
            Location::factory()->make()->toArray()
        );
        $location2->update([
            'generated_at' => Carbon::now()->format('Y-m-d 13:00:00'),
            'is_moving' => 0,
            'device_uuid' => $device->uuid,
        ]);
        $location3 = $device->locations()->create(
            Location::factory()->make()->toArray()
        );
        $location3->update([
            'generated_at' => Carbon::now()->format('Y-m-d 14:00:00'),
            'is_moving' => 1,
            'device_uuid' => $device->uuid,
        ]);
        $location4 = $device->locations()->create(
            Location::factory()->make()->toArray()
        );
        $location4->update([
            'generated_at' => Carbon::now()->format('Y-m-d 14:00:00'),
            'is_moving' => 1,
            'device_uuid' => $device->uuid,
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/reports', [
            'api_token' => $user->api_token,
            'devices' => '',
            'accuracy' => 300,
            'start_date' => Carbon::now()->format('Y-m-d 00:00:00'),
            'end_date' => Carbon::now()->format('Y-m-d 23:59:59'),
            'type' => 'activity',
        ]);
        $response->assertOk();
    }
}
