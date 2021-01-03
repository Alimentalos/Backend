<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildCanViewOwnActionsTest extends TestCase
{
    use RefreshDatabase;

    final public function testChildCanViewOwnActions()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();
        change_instance_user($userB, $user);
        $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/actions');
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }

}
