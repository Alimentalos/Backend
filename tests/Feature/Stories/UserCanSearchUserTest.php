<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanSearchUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanSearchUser()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->get('/users/search?q=' . $user->email);
        $this->assertTrue(true);
    }
}
