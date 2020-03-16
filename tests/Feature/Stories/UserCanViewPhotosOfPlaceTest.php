<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\Place;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosOfPlaceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPhotosOfPlace()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->places()->attach($place);
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/places/' . $place->uuid . '/photos');
        $response->assertOk();
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
    }

}
