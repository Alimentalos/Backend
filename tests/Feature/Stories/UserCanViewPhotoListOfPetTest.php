<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotoListOfPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPhotoListOfPet()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_uuid = $user->uuid;
        $pet->user_uuid = $user->uuid;
        $pet->photo_uuid = $photo->uuid;
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->save();
        $pet->save();
        $pet->photos()->attach($photo);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/photos');
        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data' => [[
                'location' =>[
                    'type',
                    'coordinates',
                ],
                'uuid',
                'user_uuid',
                'ext',
                'photo_url',
                'is_public',
                'created_at',
                'updated_at',
                'love_reactant_id',
                'pivot' => [
                    'photoable_id',
                    'photo_uuid',
                    'photoable_type'
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
            'photoable_id' => $pet->uuid
        ]);
    }
}
