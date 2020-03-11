<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosTest extends TestCase
{
    use RefreshDatabase;

    public function testShowPhotosApi()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_uuid = $user->uuid;
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $user->photo_uuid = $photo->uuid;
        $user->save();
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid);
//        dd($response->getContent());
        $response->assertOk();


        $response->assertJsonStructure([
            'location' =>[
                'type',
                'coordinates',
            ],
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
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
            'comment' => [
                'uuid',
                'user_uuid',
                'title',
                'body',
                'commentable_type',
                'commentable_id',
                'created_at',
                'updated_at',
                'love_reactant_id'
            ],
        ]);

        $response->assertJsonFragment([
            'uuid' => $photo->uuid
        ]);
    }
}
