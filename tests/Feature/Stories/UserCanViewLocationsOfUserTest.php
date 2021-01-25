<?php


namespace Tests\Feature\Stories;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewLocationsOfUserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewLocationsOfUser()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/locations', [
            'api_token' => $user->api_token,
            'type' => 'users',
            'identifiers' => $user->uuid,
            'accuracy' => 100,
            'start_date' => Carbon::now()->format('d-m-Y 00:00:00'),
            'end_date' => Carbon::now()->format('d-m-Y 23:59:59')
        ]);
        $response->assertOk();
    }
}
