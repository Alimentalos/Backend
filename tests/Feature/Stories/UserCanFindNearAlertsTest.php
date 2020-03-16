<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Alert;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindNearAlertsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanFindNearPets()
    {
        $user = factory(User::class)->create();
        $alerts = factory(Alert::class, 50)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/near/alerts', [
            'coordinates' => '5.1,5.3'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'location',
                    'user_uuid',
                    'photo_uuid',
                    'photo_url',
                    'alert_type',
                    'alert_id',
                    'title',
                    'body',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
