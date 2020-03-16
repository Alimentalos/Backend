<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NonVerifiedUserCannotResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testNonVerifiedUserCannotResetPassword()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/password/reset', [
            'email' => $user->email,
        ]);
        $response->assertStatus(302);
    }
}
