<?php


namespace Tests\Feature\Stories;


use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserCanReactToResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_react_to_resources()
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
        $resources = ["photo", "place", "pet", "user", "geofence", "comment"];
        foreach ($resources as $resource) {
            $model = resolve("App\\Models\\" . Str::ucfirst($resource));
            $plural = Str::plural($resource);
            $instance = $model::factory()->create();
            $response = $this->actingAs($user, 'api')
                ->json('POST', "/api/{$plural}/{$instance->uuid}/reactions", [
                    'type' => 'Love',
                ]);
            $response->assertOk();
            $response = $this->actingAs($user, 'api')
                ->json('GET', "/api/{$plural}/{$instance->uuid}/reactions");
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
                ->json('POST', "/api/{$plural}/{$instance->uuid}/reactions", [
                    'type' => 'Love',
                ]);
            $response->assertOk();
            $response = $this->actingAs($user, 'api')
                ->json('GET', "/api/{$plural}/{$instance->uuid}/reactions");
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
        $response = $this->actingAs($user, 'api')
            ->json('POST', "/api/{$plural}/{$instance->uuid}/reactions", [
                'type' => 'Love',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', "/api/{$plural}/{$instance->uuid}/reactions");
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
            ->json('POST', "/api/{$plural}/{$instance->uuid}/reactions", [
                'type' => 'Love',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', "/api/{$plural}/{$instance->uuid}/reactions");
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
