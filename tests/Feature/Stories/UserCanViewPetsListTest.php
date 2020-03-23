<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPetsListTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPetsList()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets');
        $response->assertOk();
        $response->assertJsonStructure([
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
            'data' => [
                [
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
                ]
            ]
        ]);
    }
}
