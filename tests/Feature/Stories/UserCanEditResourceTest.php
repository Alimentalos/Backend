<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanEditResourceTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanEditResource()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user)->get('/pets/' . $pet->uuid . '/edit');
        $response->assertOk();
    }
}
