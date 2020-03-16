<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanReactToPhotosTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanReactToPhotos()
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
        $photo = factory(Photo::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/photos/' . $photo->uuid . '/reactions', [
                'type' => 'Love',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/photos/' . $photo->uuid . '/reactions');
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
            ->json('POST', '/api/photos/' . $photo->uuid . '/reactions', [
                'type' => 'Love',
            ]);
        $response->assertOk();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/photos/' . $photo->uuid . '/reactions');
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
