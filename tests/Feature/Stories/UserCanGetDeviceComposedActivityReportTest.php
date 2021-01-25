<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\Group;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanGetDeviceComposedActivityReportTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetDeviceComposedActivityReport()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $group = Group::factory()->create();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location2 = $device->locations()->create(
            Location::factory()->make()->toArray()
        );
        $location2->update([
            'generated_at' => Carbon::now()->format('Y-m-d 13:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 0
        ]);
        $location3 = $device->locations()->create(
            Location::factory()->make()->toArray()
        );
        $location3->update([
            'generated_at' => Carbon::now()->format('Y-m-d 15:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 1
        ]);
        $location4 = $device->locations()->create(
            Location::factory()->make()->toArray()
        );
        $location4->update([
            'generated_at' => Carbon::now()->format('Y-m-d 16:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 1
        ]);
        $location5 = $device->locations()->create(
            Location::factory()->make()->toArray()
        );
        $location5->update([
            'generated_at' => Carbon::now()->format('Y-m-d 18:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 0
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/reports', [
            'api_token' => $user->api_token,
            'devices' => $device->uuid,
            'accuracy' => 100,
            'start_date' => Carbon::now()->subDay()->format('Y-m-d 00:00:00'),
            'end_date' => Carbon::now()->format('Y-m-d 23:59:59'),
            'type' => 'activity',
        ]);
        $response->assertOk();
        $response->assertJsonStructure([[
            'device' => [
                'uuid',
                'name',
                'description',
            ],
            'data' => [[
                'summary',
            ]],
        ]]);
        $response->assertJsonFragment([
            'uuid' => $device->uuid
        ]);
    }
}
