<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildCanViewOwnerUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testChildCanViewOwnerUser()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        change_instance_user($userB, $userA);
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
