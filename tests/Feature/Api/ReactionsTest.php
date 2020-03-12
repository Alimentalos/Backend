<?php

namespace Tests\Feature\Api;

use App\Comment;
use App\Geofence;
use App\Pet;
use App\Photo;
use App\User;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReactionsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLikePets()
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
        $userB = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $comment = factory(Comment::class)->create();
        $geofence = factory(Geofence::class)->create();
        $photo = factory(Photo::class)->create();

        // Comments
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/comments/' . $comment->uuid . '/reactions', [
               'type' => 'Like',
            ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/comments/' . $comment->uuid . '/reactions');

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
            'like' => true
        ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/comments/' . $comment->uuid . '/reactions', [
                'type' => 'Like',
            ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/comments/' . $comment->uuid . '/reactions');

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
            'like' => false
        ]);

        // Geofences
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/geofences/' . $geofence->uuid . '/reactions', [
                'type' => 'Follow',
            ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/geofences/' . $geofence->uuid . '/reactions');

        $response->assertJsonStructure([
            'reactable' => [
                'follow',
            ]
        ]);

        $response->assertJsonFragment([
            'follow' => true
        ]);

        $response->assertOk();

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

        // Pets
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/pets/' . $pet->uuid . '/reactions', [
                'type' => 'Love',
            ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/pets/' . $pet->uuid . '/reactions');

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

        $response->assertOk();

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

        // Users
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $userB->uuid . '/reactions', [
                'type' => 'Follow',
            ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/users/' . $userB->uuid . '/reactions');

        $response->assertJsonStructure([
            'reactable' => [
                'follow',
            ]
        ]);

        $response->assertJsonFragment([
            'follow' => true
        ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $userB->uuid . '/reactions', [
                'type' => 'Follow',
            ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/users/' . $userB->uuid . '/reactions');

        $response->assertOk();

        $response->assertJsonStructure([
            'reactable' => [
                'follow',
            ]
        ]);

        $response->assertJsonFragment([
            'follow' => false
        ]);

        // Photos
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/photos/' . $photo->uuid . '/reactions', [
                'type' => 'Love',
            ]);

        $response->assertOk();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/photos/' . $photo->uuid . '/reactions');

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

        $response->assertOk();

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
