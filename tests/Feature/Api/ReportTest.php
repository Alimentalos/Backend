<?php

namespace Tests\Feature\Api;

use App\Device;
use App\Group;
use App\Location;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class ReportTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanGetSpeedReport()
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

    public function testUserCanGetActivityReport()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $location1 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $group = factory(Group::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location1->update([
            'generated_at' => Carbon::now()->format('Y-m-d 11:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 1
        ]);
        $location2 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $location2->update([
            'generated_at' => Carbon::now()->format('Y-m-d 13:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 0
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/reports', [
            'api_token' => $user->api_token,
            'devices' => $device->uuid,
            'accuracy' => 100,
            'start_date' => Carbon::now()->format('Y-m-d 00:00:00'),
            'end_date' => Carbon::now()->format('Y-m-d 23:59:59'),
            'type' => 'activity',
        ]);
        $response->assertOk();
    }

    public function testUserCanGetReportWithoutDeviceParameter()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $location1 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $group = factory(Group::class)->create();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location1->update([
            'generated_at' => Carbon::now()->format('Y-m-d 11:00:00'),
            'is_moving' => 1
        ]);
        $location2 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $location2->update([
            'generated_at' => Carbon::now()->format('Y-m-d 13:00:00'),
            'is_moving' => 0
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/reports', [
            'api_token' => $user->api_token,
            'devices' => '',
            'accuracy' => 100,
            'start_date' => Carbon::now()->format('Y-m-d 00:00:00'),
            'end_date' => Carbon::now()->format('Y-m-d 23:59:59'),
            'type' => 'activity',
        ]);
        $response->assertOk();
    }

    public function testUserCanGetActivityReportWithData()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $location1 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $group = factory(Group::class)->create();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location1->update([
            'generated_at' => Carbon::now()->format('Y-m-d 11:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 1
        ]);
        $location2 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $location2->update([
            'generated_at' => Carbon::now()->format('Y-m-d 13:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 0
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/reports', [
            'api_token' => $user->api_token,
            'devices' => $device->uuid,
            'accuracy' => 100,
            'start_date' => Carbon::now()->format('Y-m-d 00:00:00'),
            'end_date' => Carbon::now()->addDays(2)->format('Y-m-d 23:59:59'),
            'type' => 'activity',
        ]);
        $response->assertOk();
    }
}
