<?php

namespace Tests\Feature\Api;

use App\Device;
use App\Location;
use App\Group;
use App\Pet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class FindTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testFindDeviceApi
     */
    final public function testFindDeviceApi()
    {
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $group = factory(Group::class)->create();
        $device->locations()->saveMany(
            factory(Location::class, 10)->make()
        );
        $group->devices()->attach($device->id);
        $group->users()->attach($user->id);
        $responseDevices = $this->actingAs($user, 'api')->json('GET', '/api/find', [
            'api_token' => $user->api_token,
            'type' => 'devices',
            'identifiers' => [$device->uuid],
            'accuracy' => 100,
        ]);
        $responseDevices->assertJsonStructure([
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
        $responseDevices->assertOk();
    }

    /**
     * @test testFindPetApi
     */
    final public function testFindPetApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->locations()->saveMany(
            factory(Location::class, 10)->make()
        );
        $responsePets = $this->actingAs($user, 'api')->json('GET', '/api/find', [
            'api_token' => $user->api_token,
            'type' => 'pets',
            'identifiers' => [$pet->uuid],
            'accuracy' => 100,
        ]);
        $responsePets->assertJsonStructure([
            [
                'trackable_id',
                'trackable_type',
                'uuid',
                'accuracy',
                'longitude',
                'latitude',
                'created_at'
            ]
        ]);
        $responsePets->assertOk();
    }

    /**
     * @test testFindUserApi
     */
    final public function testFindUserApi()
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

    /**
     * @test testFindEmptyPetApi
     */
    final public function testFindEmptyPetApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $responsePets = $this->actingAs($user, 'api')->json('GET', '/api/find', [
            'api_token' => $user->api_token,
            'type' => 'pets',
            'identifiers' => [$pet->uuid],
            'accuracy' => 100,
        ]);
        $responsePets->assertExactJson([]);
        $responsePets->assertOk();
    }
}
