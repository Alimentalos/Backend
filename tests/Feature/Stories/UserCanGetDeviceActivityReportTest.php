<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\Group;
use App\Location;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanGetDeviceActivityReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testUserCanGetDeviceActivityReport
     */
    public function testUserCanGetDeviceActivityReport()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $group = factory(Group::class)->create();
        $user->groups()->save($group);
        $group->devices()->save($device);
        $location2 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $location2->update([
            'generated_at' => Carbon::now()->format('Y-m-d 13:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 0
        ]);

        $location3 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $location3->update([
            'generated_at' => Carbon::now()->format('Y-m-d 15:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 1
        ]);

        $location4 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
        );
        $location4->update([
            'generated_at' => Carbon::now()->format('Y-m-d 16:00:00'),
            'device_uuid' => $device->uuid,
            'is_moving' => 1
        ]);

        $location5 = $device->locations()->create(
            factory(Location::class)->make()->toArray()
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
            'start_date' => Carbon::now()->format('Y-m-d 00:00:00'),
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
                'summary'=> [
                    'status',
                    'from',
                    'to',
                    'in_moving_time',
                    'stopped_time',
                    'distance',
                    'altitude'
                ],
                'start_point' =>[
                    'time',
                    'latitude',
                    'longitude',
                    'altitude',
                    'street'
                ],
                'end_point' => [
                    'time',
                    'latitude',
                    'longitude',
                    'altitude',
                    'street'
                ],
                'ranges' => [[
                    'summary' => [
                        'status',
                        'time',
                        'distance',
                        'altitude',
                    ],
                    'from' => [
                        'time',
                        'latitude',
                        'longitude',
                        'altitude',
                        'street'
                    ],
                    'to' => [
                        'time',
                        'latitude',
                        'longitude',
                        'altitude',
                        'street'
                    ],
                    'battery' => [
                        'start',
                        'end',
                        'usage'
                    ],
                ]],
            ]],
        ]]);

        $response->assertJsonFragment([
            'uuid' => $device->uuid
        ]);

    }
}
