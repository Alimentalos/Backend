<?php


namespace Tests\Feature\Stories;


use App\Models\Action;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministratorCanDeleteActionTest extends TestCase
{
    use RefreshDatabase;

    final public function testAdministratorCanDeleteAction()
    {
        $user = create_admin();
        $action = Action::factory()->create();
        change_instance_user($action, $user);
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/actions/' . $action->uuid);
        $response->assertOk();
    }
}
