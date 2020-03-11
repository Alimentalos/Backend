<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildUserCanViewOwnerUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserWatchingOwner
     */
    final public function testUserWatchingOwner()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $userA->uuid;
        $userB->is_public = false;
        $userB->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/users/' . $userA->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $userA->name,
            'email' => $userA->email,
        ]);
    }
}
