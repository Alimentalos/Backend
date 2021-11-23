<?php


namespace Tests\Feature\Stories;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanRecoveryPasswordViaApiTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRecoveryPasswordViaApi()
    {
        $user = User::factory()->create();
        $response = $this->json('POST', '/api/password-recovery', [
            'email' => $user->email,
        ]);
        $response->assertOk();
    }
}
