<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPetsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPets()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
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
            'is_public',
            'created_at',
            'updated_at',
            'user',
            'photo',
        ]);
    }
}
