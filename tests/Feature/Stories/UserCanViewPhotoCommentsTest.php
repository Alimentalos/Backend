<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Pet;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserCanViewPhotoCommentsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test testIndexPhotosCommentsApi
     */
    final public function testIndexPhotosCommentsApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_uuid = $user->uuid;
        $photo->pets()->attach($pet);
        $photo->save();
        $comment = factory(Comment::class)->make();
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
                'user' =>[
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'email',
                    'email_verified_at',
                    'free',
                    'photo_url',
                    'location' =>[
                        'type',
                        'coordinates',
                    ],
                    'is_public',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                    'love_reacter_id',
                    'is_admin',
                    'is_child',
                ],
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
