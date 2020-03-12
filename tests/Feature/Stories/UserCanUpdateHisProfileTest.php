<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanUpdateHisProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanUpdateUser
     */
    final public function testUserCanUpdateUser()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/users/' . $user->uuid, [
            'name' => 'New name',
            'coordinates' => '5.5,6.5',
        ]);

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
            'name' => 'New name',
            'email' => $user->email,
        ]);
    }
}