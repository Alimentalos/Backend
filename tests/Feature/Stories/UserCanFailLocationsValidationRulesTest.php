<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFailLocationsValidationRulesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanFailLocationsValidationRules()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/locations', [
            'api_token' => $user->api_token,
            'identifiers' => $device->uuid,
            'accuracy' => 100,
        ]);
        $response->assertStatus(422);
    }
}
