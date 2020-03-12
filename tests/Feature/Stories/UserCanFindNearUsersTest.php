<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindNearUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanFindNearUsers
     */
    public function testUserCanFindNearUsers()
    {
        $user = factory(User::class)->create();
        $users = factory(User::class, 50)->create();
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
