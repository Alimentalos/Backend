<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NonVerifiedUserReceivesUnauthorizedTest extends TestCase
{
    use RefreshDatabase;

    final public function testNonVerifiedUserReceivesUnauthorized()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $group->devices()->attach($device->uuid);
        $group->users()->attach($user->uuid);
        $user->email_verified_at = null;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertStatus(403);
    }
}
