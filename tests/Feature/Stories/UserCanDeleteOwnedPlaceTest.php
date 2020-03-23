<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanDeleteOwnedPlaceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanDeleteOwnedPlace()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create();
        $place->user_uuid = $user->uuid;
        $place->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/places/' . $place->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
            'message' => 'Resource deleted successfully'
        ]);

    }
}
