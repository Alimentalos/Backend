<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildCanViewOwnActionsTest extends TestCase
{
    use RefreshDatabase;

    final public function testChildCanViewOwnActions()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $userB->user_uuid = $user->uuid;
        $userB->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/actions');
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }

}
