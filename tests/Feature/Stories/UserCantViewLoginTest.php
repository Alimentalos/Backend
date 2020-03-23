<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCantViewLoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCantViewLogin()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/login');
        $response->assertRedirect('home');
    }
}
