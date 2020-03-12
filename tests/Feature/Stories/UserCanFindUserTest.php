<?php


namespace Tests\Feature\Stories;


use App\Location;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanFindUser()
    {
        $user = factory(User::class)->create();
        $user->locations()->saveMany(
            factory(Location::class, 10)->make()
        );
        $responseUsers = $this->actingAs($user, 'api')->json('GET', '/api/find', [
            'api_token' => $user->api_token,
            'type' => 'users',
            'identifiers' => [$user->uuid],
            'accuracy' => 100,
        ]);
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
        $responseUsers->assertOk();
    }
}
