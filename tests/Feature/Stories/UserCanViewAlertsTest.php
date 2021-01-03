<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewAlertsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewAlerts()
    {
        $user = User::factory()->create();
        $alert = Alert::factory()->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/alerts');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'location',
                    'user',
                    'photo',
                    'alert'
                ]
            ]
        ]);
    }
}
