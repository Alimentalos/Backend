<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewNonOwnedUsersTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewNonOwnedUsers()
    {
        $user = User::factory()->create();
        $userC = User::factory()->create();
        $userB = User::factory()->create();
        $userC->is_public = false;
        $userB->user_uuid = $user->uuid;
        $userC->user_uuid = $user->uuid;
        $userB->save();
        $userC->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/users/' . $userC->uuid);
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
            'name' => $userC->name,
            'email' => $userC->email,
        ]);
    }
}
