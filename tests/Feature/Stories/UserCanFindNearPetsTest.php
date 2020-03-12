<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindNearPetsTest extends TestCase
{
    use RefreshDatabase;

    public function UserCanFindNearPetsTest()
    {
        $user = factory(User::class)->create();
        $pets = factory(Pet::class, 50)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/near/pets', [
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
