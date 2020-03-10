<?php


namespace Tests\Feature\Stories;


use App\Geofence;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserCanGetGeofencesPhotosTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test testIndexGeofencesPhotosApi
     */
    final public function testIndexGeofencesPhotosApi()
    {
        $user = factory(User::class)->create();
        $geofence = factory(Geofence::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->geofences()->attach($geofence->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/geofences/' . $geofence->uuid . '/photos');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }
}
