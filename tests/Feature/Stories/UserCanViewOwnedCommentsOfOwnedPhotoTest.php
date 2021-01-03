<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnedCommentsOfOwnedPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnedCommentsOfOwnedPhoto()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $photo = Photo::factory()->create();
        $photo->user_uuid = $user->uuid;
        $photo->pets()->attach($pet);
        $photo->save();
        $comment = Comment::factory()->make();
        $photo->comments()->create([
            'uuid' => uuid(),
            'user_uuid' => $user->uuid,
            'body' => $comment->body,
        ]);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid . '/comments');
        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data' => [[
                'uuid',
                'user_uuid',
                'title',
                'body',
                'commentable_type',
                'commentable_id',
                'created_at',
                'updated_at',
                'love_reactant_id',
            ]],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);
    }
}
