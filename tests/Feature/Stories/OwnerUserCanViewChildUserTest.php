<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OwnerUserCanViewChildUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test testOwnerUserWatchingSpecificUser
     */
    final public function testOwnerUserWatchingSpecificUser()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->is_public = false;
        $userB->user_uuid = $user->uuid;
        $userB->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $userB->uuid);
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
            'name' => $userB->name,
            'email' => $userB->email,
        ]);
    }
}
