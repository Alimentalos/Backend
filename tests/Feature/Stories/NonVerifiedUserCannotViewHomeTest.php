<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NonVerifiedUserCannotViewHomeTest extends TestCase
{
    use RefreshDatabase;

    public function NonVerifiedUserCannotViewHomeTest()
    {
        $user = factory(User::class)->create();
        $user->email_verified_at = null;
        $user->save();
        $response = $this->actingAs($user)
            ->get('/home');
        $response->assertStatus(302);
    }
}
