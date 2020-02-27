<?php

namespace Tests\Feature\Api;

use App\Action;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ActionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testUserCanViewActionsAsList
     */
    final public function testUserCanViewActionsAsList()
    {
        $user = factory(User::class)->create();
        $child = factory(User::class)->create();
        $user->user_id = null;
        $child->user_id = $user->id;
        $child->save();
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertOk();
        $this->actingAs($child, 'api')->json('GET', '/api/devices')->assertOk();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/actions')->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
                    'referenced_id',
                    'type',
                    'resource',
                    'parameters',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
        $response->assertJsonCount(3, 'data');
        $response->assertOk();
    }

    /**
     * @test testChildUserCanViewActionsAsList
     */
    final public function testChildUserCanViewActionsAsList()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $userB->user_id = $user->id;
        $userB->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/actions');
        $response->assertJsonCount(1, 'data');
        $response->assertOk();
    }

    /**
     * @test testUserCanViewAnAction
     */
    final public function testUserCanViewAnAction()
    {
        $user = factory(User::class)->create();
        $action = factory(Action::class)->create();
        $action->user_id = $user->id;
        $action->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/actions/' . $action->uuid);
        $response->assertOk();
    }

    /**
     * @test testAdministratorUserCanDeleteAction
     */
    final public function testAdministratorUserCanDeleteAction()
    {
        $user = factory(User::class)->create();
        $user->email = 'iantorres@outlook.com';
        $user->save();
        $action = factory(Action::class)->create();
        $action->user_id = $user->id;
        $action->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/actions/' . $action->uuid);
        $response->assertOk();
    }
}
