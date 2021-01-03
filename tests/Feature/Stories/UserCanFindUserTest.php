<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Location;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanFindUser()
    {
        $user = User::factory()->create();
        $user->locations()->saveMany(
            Location::factory(10)->make()
        );
        $responseUsers = $this->actingAs($user, 'api')->json('GET', '/api/find', [
            'api_token' => $user->api_token,
            'type' => 'users',
            'identifiers' => [$user->uuid],
            'accuracy' => 100,
        ]);
        $responseUsers->assertOk();
        $responseUsers->assertJsonStructure([
            [
                'trackable_id',
                'trackable_type',
                'uuid',
                'accuracy',
                'altitude',
                'longitude',
                'latitude',
                'speed',
                'generated_at',
                'created_at'
            ]
        ]);
    }
}
