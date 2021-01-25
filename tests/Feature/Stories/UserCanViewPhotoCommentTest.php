<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotoCommentTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPhotoComment()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $photo = Photo::factory()->create();
        $photo->pets()->attach($pet);
        $photo->save();
        $comment = Comment::factory()->make();
        $photo->comments()->create([
            'user_uuid' => $user->uuid,
            'body' => $comment->body,
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid . '/comments');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'body',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }
}
