<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewAlertTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewAlert()
    {
        $user = User::factory()->create();
        $alert = Alert::factory()->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/alerts/' . $alert->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'location',
            'user',
            'photo',
            'alert'
        ]);
    }
}
