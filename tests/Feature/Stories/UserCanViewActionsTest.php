<?php


namespace Tests\Feature\Stories;


use App\Action;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewActionsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewActions()
    {
        $user = factory(User::class)->create();
        $action = factory(Action::class)->create();
        $action->user_uuid = $user->uuid;
        $action->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/actions/' . $action->uuid);
        $response->assertOk();
    }
}
