<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Group;
use App\Location;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanGetDeviceActivityReportWithoutParameterTest extends TestCase
{
    use RefreshDatabase;

    public function UserCanGetDeviceActivityReportWithoutParameterTest()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $group = factory(Group::class)->create();
        $device->save();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location1 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $group = factory(Group::class)->create();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location1->update([
            'generated_at' => Carbon::now()->format('Y-m-d 11:00:00'),
            'is_moving' => 1,
            'device_uuid' => $device->uuid,
        ]);
        $location2 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $location2->update([
            'generated_at' => Carbon::now()->format('Y-m-d 13:00:00'),
            'is_moving' => 0,
            'device_uuid' => $device->uuid,
        ]);
        $location3 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $location3->update([
            'generated_at' => Carbon::now()->format('Y-m-d 14:00:00'),
            'is_moving' => 1,
            'device_uuid' => $device->uuid,
        ]);
        $location4 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
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
