<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewLocationsOfPetTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewLocationsOfPet()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/locations', [
            'api_token' => $user->api_token,
            'type' => 'pets',
            'identifiers' => $pet->uuid,
            'accuracy' => 100,
            'start_date' => Carbon::now()->format('d-m-Y 00:00:00'),
            'end_date' => Carbon::now()->format('d-m-Y 23:59:59')
        ]);
        $response->assertOk();
    }

}
