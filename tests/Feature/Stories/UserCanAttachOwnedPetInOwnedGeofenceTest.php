<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanAttachOwnedPetInOwnedGeofenceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testAttachPetsGeofencesApi
     */
    public function testAttachPetsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $response = $this->actingAs($user, 'api')->json(
            'POST',
            '/api/pets/' . $pet->uuid . '/geofences/' . $geofence->uuid . '/attach',
            []
        );
        $this->assertDatabaseHas('geofenceables', [
            'geofenceable_id' => $pet->uuid,
            'geofenceable_type' => 'App\\Pet',
            'geofence_uuid' => $geofence->uuid,
        ]);
        $response->assertOk();
    }

}
