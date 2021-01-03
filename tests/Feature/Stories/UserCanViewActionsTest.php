<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Action;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewActionsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewActions()
    {
        $user = User::factory()->create();
        $action = Action::factory()->create();
        $action->user_uuid = $user->uuid;
        $action->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/actions/' . $action->uuid);
        $response->assertOk();
    }
}
