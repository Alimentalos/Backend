<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NonVerifiedUserReceivesUnauthorizedTest extends TestCase
{
    use RefreshDatabase;

    final public function testNonVerifiedUserReceivesUnauthorized()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $group = Group::factory()->create();
        $group->devices()->attach($device->uuid);
        $group->users()->attach($user->uuid);
        $user->email_verified_at = null;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertStatus(403);
    }
}
