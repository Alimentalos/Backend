<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\Photo;
use App\User;
use Tests\TestCase;

class UserCanViewPetPhotosTest extends TestCase
{
    /**
     * @test testIndexPetsPhotosApi
     */
    final public function testIndexPetsPhotosApi()
    {
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->pets()->attach($pet->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/pets/' . $pet->uuid . '/photos');
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'uuid',
                    'ext',
                    'user',
                    'comment',
                    'is_public',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertOk();
    }
}
