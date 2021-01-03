<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotoListOfPetTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPhotoListOfPet()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();
        $photo = Photo::factory()->create();
        $photo->user_uuid = $user->uuid;
        $pet->user_uuid = $user->uuid;
        $pet->photo_uuid = $photo->uuid;

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
