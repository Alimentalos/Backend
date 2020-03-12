<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifiedUserViewDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testVerifiedUserViewDashboard
     */
    public function testVerifiedUserViewDashboard()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/home');
        $response->assertStatus(200);
    }
}
