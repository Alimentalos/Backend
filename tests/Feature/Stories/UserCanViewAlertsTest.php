<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Alert;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewAlertsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewAlerts()
    {
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $response = $this->actingAs($user, 'api')->get('/api/alerts');
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
