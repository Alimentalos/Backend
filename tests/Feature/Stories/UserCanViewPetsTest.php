<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPetsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPets()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid);
        $response->assertOk();

        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'photo_uuid',
            'name',
            'description',
            'hair_color',
            'left_eye_color',
            'size',
            'born_at',
            'api_token',
            'is_public',
            'created_at',
            'updated_at',
            'user',
            'photo',
        ]);
    }
}
