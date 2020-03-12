<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerCanViewChildUserTest extends TestCase
{
    use RefreshDatabase;

    final public function OwnerCanViewChildUserTest()
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
