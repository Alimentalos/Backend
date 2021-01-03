<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosOfPlaceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPhotosOfPlace()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $photo = Photo::factory()->create();
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
