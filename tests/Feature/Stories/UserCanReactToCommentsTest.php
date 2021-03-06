<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanReactToCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanReactToComments()
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
        $comment = Comment::factory()->create();
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
    }

}
