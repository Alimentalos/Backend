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
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $response = $this->actingAs($user, 'api')->get('/api/alerts/' . $alert->uuid);
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
