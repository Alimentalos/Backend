<?php


namespace Tests\Feature\Stories;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindNearUsersTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanFindNearUsers()
    {
        $user = User::factory()->create();
        $users = User::factory(50)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/near/users', [
            'coordinates' => '5.1,5.3'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'name',
                    'is_public',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
