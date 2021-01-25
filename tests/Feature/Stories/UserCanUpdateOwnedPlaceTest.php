<?php


namespace Tests\Feature\Stories;


use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanUpdateOwnedPlaceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdateOwnedPlace()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
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
