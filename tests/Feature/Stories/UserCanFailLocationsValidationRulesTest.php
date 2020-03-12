<?php


namespace Tests\Feature\Stories;


use App\Device;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFailLocationsValidationRulesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanFailLocationsValidationRules()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/locations', [
            'api_token' => $user->api_token,
            'identifiers' => $device->uuid,
            'accuracy' => 100,
        ]);
        $response->assertStatus(422);
    }
}
