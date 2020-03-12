<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NonVerifiedUserCannotResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testNonVerifiedUserCannotResetPassword
     */
    public function testNonVerifiedUserCannotResetPassword()
    {
        $user = factory(User::class)->make();
        $response = $this->post('/password/reset', [
            'email' => $user->email,
        ]);
        $response->assertStatus(302);
    }
}
