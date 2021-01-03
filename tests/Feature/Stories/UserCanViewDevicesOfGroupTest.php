<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewDevicesOfGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewDevicesOfGroup()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $group = Group::factory()->create();
        $group->devices()->attach($device->uuid);
        $group->users()->attach($user->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/groups/' . $group->uuid . '/devices');
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
        ]);
    }
}
