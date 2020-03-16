<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifiedUserCanViewDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedUserCanViewDashboard()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/home');
        $response->assertOk();
    }
}
