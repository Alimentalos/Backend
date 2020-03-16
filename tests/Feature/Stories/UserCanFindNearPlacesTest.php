<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Place;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindNearPlacesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanFindNearPets()
    {
        $user = factory(User::class)->create();
        $places = factory(Place::class, 50)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/near/places', [
            'coordinates' => '5.1,5.3'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'location',
                    'name',
                    'is_public',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
