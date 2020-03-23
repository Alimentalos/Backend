<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Action;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministratorCanDeleteActionTest extends TestCase
{
    use RefreshDatabase;

    final public function testAdministratorCanDeleteAction()
    {
        $user = factory(User::class)->create();
        $user->email = 'iantorres@outlook.com';
        $user->save();
        $action = factory(Action::class)->create();
        $action->user_uuid = $user->uuid;
        $action->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/actions/' . $action->uuid);
        $response->assertOk();
    }
}
