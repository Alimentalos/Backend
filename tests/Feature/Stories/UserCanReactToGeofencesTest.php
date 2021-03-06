<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanReactToGeofencesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanReactToGeofences()
    {
        $this->artisan('love:reaction-type-add --name=Hate --mass=-4')
            ->assertExitCode(0);
        $this->artisan('love:reaction-type-add --name=Sad --mass=-2')
            ->assertExitCode(0);
        $this->artisan('love:reaction-type-add --name=Dislike --mass=-1')
            ->assertExitCode(0);
        $this->artisan('love:reaction-type-add --name=Like --mass=1')
            ->assertExitCode(0);
        $this->artisan('love:reaction-type-add --name=Pray --mass=2')
            ->assertExitCode(0);
        $this->artisan('love:reaction-type-add --name=Love --mass=5')
            ->assertExitCode(0);
        $this->artisan('love:reaction-type-add --name=Follow --mass=1')
            ->assertExitCode(0);
        $user = User::factory()->create();
        $geofence = Geofence::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/geofences/' . $geofence->uuid . '/reactions', [
                'type' => 'Follow',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/geofences/' . $geofence->uuid . '/reactions');
        $response->assertOk();
        $response->assertJsonStructure([
            'reactable' => [
                'follow',
            ]
        ]);
        $response->assertJsonFragment([
            'follow' => true
        ]);
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/geofences/' . $geofence->uuid . '/reactions', [
                'type' => 'Follow',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/geofences/' . $geofence->uuid . '/reactions');
        $response->assertOk();
        $response->assertJsonStructure([
            'reactable' => [
                'follow',
            ]
        ]);
        $response->assertJsonFragment([
            'follow' => false
        ]);
    }

}
