<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnUser()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/user');
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
