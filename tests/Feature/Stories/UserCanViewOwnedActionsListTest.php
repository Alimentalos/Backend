<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedActionsListTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedActionsList()
    {
        $user = factory(User::class)->create();
        $child = factory(User::class)->create();
        $user->user_uuid = null;
        $child->user_uuid = $user->uuid;
        $child->save();
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices');
        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);

        $response = $this->actingAs($child, 'api')->json('GET', '/api/devices');
        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/actions');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'referenced_uuid',
                    'type',
                    'resource',
                    'parameters',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);
        $response->assertJsonCount(3, 'data');
    }
}
