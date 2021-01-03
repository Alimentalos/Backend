<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindNearPetsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanFindNearPets()
    {
        $user = User::factory()->create();
        $pets = Pet::factory(50)->create();
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
