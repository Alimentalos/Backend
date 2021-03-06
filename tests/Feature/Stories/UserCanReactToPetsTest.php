<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanReactToPetsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanReactToPets()
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
        $pet = Pet::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/pets/' . $pet->uuid . '/reactions', [
                'type' => 'Love',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/pets/' . $pet->uuid . '/reactions');
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
            ->json('POST', '/api/pets/' . $pet->uuid . '/reactions', [
                'type' => 'Love',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/pets/' . $pet->uuid . '/reactions');
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
