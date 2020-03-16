<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\Place;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanReactToPlacesTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanReactToPlaces()
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
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/places/' . $place->uuid . '/reactions', [
                'type' => 'Love',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/places/' . $place->uuid . '/reactions');
        $response->assertOk();
        $response->assertJsonStructure([
            'reactable' => [
                'like',
                'pray',
                'love',
                'hate',
                'dislike',
                'sad',
            ]
        ]);
        $response->assertJsonFragment([
            'love' => true
        ]);
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/places/' . $place->uuid . '/reactions', [
                'type' => 'Love',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/places/' . $place->uuid . '/reactions');
        $response->assertOk();
        $response->assertJsonStructure([
            'reactable' => [
                'like',
                'pray',
                'love',
                'hate',
                'dislike',
                'sad',
            ]
        ]);
        $response->assertJsonFragment([
            'love' => false
        ]);
    }
}
