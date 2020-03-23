<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanUpdateOwnedPlaceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdateOwnedPlace()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create();
        $place->user_uuid = $user->uuid;
        $place->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/places/' . $place->uuid, [
            'name' => 'New name',
            'is_public' => false,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'uuid',
            'name',
            'description',
            'created_at',
            'updated_at'
        ]);
        $response->assertJsonFragment([
            'uuid' => $place->uuid,
        ]);
    }
}
