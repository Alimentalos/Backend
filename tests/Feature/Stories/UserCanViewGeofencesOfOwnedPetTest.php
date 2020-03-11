<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\Pet;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserCanViewGeofencesOfOwnedPetTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test testPetsGeofencesApi
     */
    public function testPetsGeofencesApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $pet->user_uuid = $user->uuid;
        $pet->save();
        $pet->geofences()->attach($geofence);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/geofences');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
                    'shape' => [
                        'type',
                        'coordinates'
                    ],
                    'is_public',
                    'created_at',
                    'updated_at',
                    'pivot' => [
                        'geofenceable_id',
                        'geofenceable_type',
                        'geofence_uuid',
                    ]
                ]
            ]
        ]);
        $response->assertOk();
    }
}
