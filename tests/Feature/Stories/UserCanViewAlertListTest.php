<?php


namespace Tests\Feature\Stories;


use App\Alert;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewAlertListTest extends TestCase
{
    use RefreshDatabase;

    public function UserCanViewAlertListTest()
    {
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $response = $this->actingAs($user, 'api')->get('/api/alerts');
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
